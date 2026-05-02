<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Election;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidateController extends Controller
{
    // Guard check helper
    private function guardCheck()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }
        return null;
    }

    // List all candidate applications
    public function index(Request $request)
    {
        if ($redirect = $this->guardCheck()) return $redirect;

        // Get active election
        $election = Election::whereIn('status', ['draft', 'ongoing'])->first();

        $candidates = Candidate::with(['user', 'position', 'election'])
            ->when($election, fn($q) => $q->where('election_id', $election->id))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->get();

        return view('admin.candidates.index', compact('candidates', 'election'));
    }

    // Show a single application
    public function show(Candidate $candidate)
    {
        if ($redirect = $this->guardCheck()) return $redirect;

        $candidate->load(['user', 'position', 'election']);

        return view('admin.candidates.show', compact('candidate'));
    }

    // Approve application
    public function approve(Candidate $candidate)
    {
        if ($redirect = $this->guardCheck()) return $redirect;

        if (!$candidate->isPending()) {
            return back()->with('error', 'This application has already been reviewed.');
        }

        $candidate->update([
            'status'  => 'approved',
            'remarks' => null,
        ]);

        return redirect()->route('admin.candidates.index')
                         ->with('success', $candidate->user->name . ' has been approved as a candidate.');
    }

    // Reject application
    public function reject(Request $request, Candidate $candidate)
    {
        if ($redirect = $this->guardCheck()) return $redirect;

        if (!$candidate->isPending()) {
            return back()->with('error', 'This application has already been reviewed.');
        }

        $request->validate([
            'remarks' => ['required', 'string', 'max:500'],
        ]);

        $candidate->update([
            'status'  => 'rejected',
            'remarks' => $request->remarks,
        ]);

        return redirect()->route('admin.candidates.index')
                         ->with('success', $candidate->user->name . '\'s application has been rejected.');
    }
}