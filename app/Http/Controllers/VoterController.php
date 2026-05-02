<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Candidate;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class VoterController extends Controller
{
    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Get active election (draft or ongoing)
        $election = Election::whereIn('status', ['draft', 'ongoing', 'closed'])
                            ->latest()
                            ->first();

        // Has the user applied as candidate for this election?
        $application = null;
        $hasApplied  = false;

        if ($election) {
            $application = Candidate::with(['position', 'election'])
                                    ->where('user_id', $user->id)
                                    ->where('election_id', $election->id)
                                    ->first();
            $hasApplied = $application !== null;
        }

        // Has the user voted in this election?
        $hasVoted      = false;
        $userVotes     = collect();
        $totalPositions = 0;

        if ($election) {
            $totalPositions = $election->positions()->count();
            $userVotes      = Vote::with(['position', 'candidate.user'])
                                  ->where('user_id', $user->id)
                                  ->where('election_id', $election->id)
                                  ->get();
            $hasVoted = $userVotes->count() >= $totalPositions && $totalPositions > 0;
        }

        // Can the user apply as candidate?
        $canApply = $election
                    && in_array($election->status, ['draft', 'ongoing'])
                    && !$hasApplied;

        // Can the user vote?
        $canVote = $election
                   && $election->status === 'ongoing'
                   && !$hasVoted;

        // Can the user see results?
        $canViewResults = $election
                          && ($election->status === 'ongoing'
                              || ($election->status === 'closed' && $election->results_published));

        return view('voter.dashboard', compact(
            'user',
            'election',
            'application',
            'hasApplied',
            'hasVoted',
            'userVotes',
            'canApply',
            'canVote',
            'canViewResults'
        ));
    }

    // Show candidates running in the active election
    public function candidates()
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $election = Election::whereIn('status', ['draft', 'ongoing'])->first();

    if (!$election) {
        return redirect()->route('voter.dashboard')
                         ->with('error', 'No active election at the moment.');
    }

    $positions = $election->positions()
                          ->with(['candidates' => function ($q) {
                              $q->where('status', 'approved')->with('user');
                          }])
                          ->orderBy('order')
                          ->get();

    return view('voter.candidates', compact('election', 'positions'));
}
}