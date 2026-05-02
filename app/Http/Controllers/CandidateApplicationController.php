<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Election;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidateApplicationController extends Controller
{
    // Show apply as candidate form
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Get active election
        $election = Election::whereIn('status', ['draft', 'ongoing'])->first();

        if (!$election) {
            return redirect()->route('voter.dashboard')
                             ->with('error', 'There is no active election to apply for.');
        }

        // Check if user already applied for this election
        $alreadyApplied = Candidate::where('user_id', $user->id)
                                   ->where('election_id', $election->id)
                                   ->exists();

        if ($alreadyApplied) {
            return redirect()->route('voter.dashboard')
                             ->with('error', 'You have already submitted a candidate application for this election.');
        }

        // Get positions for the active election
        $positions = $election->positions()->orderBy('order')->get();

        if ($positions->isEmpty()) {
            return redirect()->route('voter.dashboard')
                             ->with('error', 'No positions are available for this election yet.');
        }

        return view('voter.apply-candidate', compact('election', 'positions'));
    }

    // Store candidate application
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $election = Election::whereIn('status', ['draft', 'ongoing'])->first();

        if (!$election) {
            return redirect()->route('voter.dashboard')
                             ->with('error', 'There is no active election.');
        }

        // Double check — already applied?
        $alreadyApplied = Candidate::where('user_id', $user->id)
                                   ->where('election_id', $election->id)
                                   ->exists();

        if ($alreadyApplied) {
            return redirect()->route('voter.dashboard')
                             ->with('error', 'You have already applied for this election.');
        }

        $request->validate([
            'position_id' => ['required', 'exists:positions,id'],
            'platform'    => ['required', 'string', 'min:50', 'max:2000'],
            'document'    => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
        ], [
            'platform.min' => 'Your platform must be at least 50 characters.',
        ]);

        // Verify position belongs to this election
        $position = $election->positions()->findOrFail($request->position_id);

        // Store document
        $documentPath = $request->file('document')->store('candidate_documents', 'public');

        Candidate::create([
            'user_id'     => $user->id,
            'election_id' => $election->id,
            'position_id' => $position->id,
            'platform'    => $request->platform,
            'document'    => $documentPath,
            'status'      => 'pending',
        ]);

        return redirect()->route('voter.dashboard')
                         ->with('success', 'Your application has been submitted. Please wait for admin approval.');
    }

    // Show application status on voter dashboard
    public function status()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $application = Candidate::with(['election', 'position'])
                                ->where('user_id', $user->id)
                                ->latest()
                                ->first();

        return view('voter.application-status', compact('application'));
    }
}