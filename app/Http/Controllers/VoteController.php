<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\Position;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    // Show the voting page
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Get the ongoing election
        $election = Election::where('status', 'ongoing')->first();

        if (!$election) {
            return redirect()->route('voter.dashboard')
                             ->with('error', 'There is no ongoing election at the moment.');
        }

        // Get positions with their approved candidates
        $positions = $election->positions()
                              ->with(['candidates' => function ($q) {
                                  $q->where('status', 'approved')->with('user');
                              }])
                              ->orderBy('order')
                              ->get();

        // Get positions this user has already voted for
        $votedPositionIds = Vote::where('user_id', $user->id)
                                ->where('election_id', $election->id)
                                ->pluck('position_id')
                                ->toArray();

        // Check if user has voted for ALL positions
        $totalPositions  = $positions->count();
        $totalVoted      = count($votedPositionIds);
        $hasVotedForAll  = $totalPositions > 0 && $totalVoted >= $totalPositions;

        return view('voter.vote', compact(
            'election',
            'positions',
            'votedPositionIds',
            'hasVotedForAll'
        ));
    }

    // Cast votes — submitted all at once
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Get ongoing election
        $election = Election::where('status', 'ongoing')->first();

        if (!$election) {
            return redirect()->route('voter.dashboard')
                             ->with('error', 'There is no ongoing election.');
        }

        // Get all positions for this election
        $positions = $election->positions()->orderBy('order')->get();

        // Validate — one candidate selection per position
        $rules = [];
        foreach ($positions as $position) {
            $rules['candidate_' . $position->id] = ['required', 'exists:candidates,id'];
        }

        $request->validate($rules, [
            'candidate_*.required' => 'Please select a candidate for every position.',
        ]);

        // Check user hasn't already voted for any position
        $alreadyVoted = Vote::where('user_id', $user->id)
                            ->where('election_id', $election->id)
                            ->exists();

        if ($alreadyVoted) {
            return redirect()->route('voter.dashboard')
                             ->with('error', 'You have already cast your votes.');
        }

        // Store all votes in a single transaction
        DB::transaction(function () use ($request, $user, $election, $positions) {
            foreach ($positions as $position) {
                $candidateId = $request->input('candidate_' . $position->id);

                // Verify candidate belongs to this position and is approved
                $candidate = Candidate::where('id', $candidateId)
                                      ->where('position_id', $position->id)
                                      ->where('election_id', $election->id)
                                      ->where('status', 'approved')
                                      ->firstOrFail();

                Vote::create([
                    'user_id'      => $user->id,
                    'election_id'  => $election->id,
                    'position_id'  => $position->id,
                    'candidate_id' => $candidate->id,
                ]);
            }
        });

        // Store receipt in session before redirecting
        $receipt = [];
        foreach ($positions as $position) {
            $candidateId = $request->input('candidate_' . $position->id);
            $candidate   = Candidate::with('user')->find($candidateId);
            $receipt[]   = [
                'position'  => $position->name,
                'candidate' => $candidate->user->name,
            ];
        }

        session(['vote_receipt' => $receipt, 'receipt_election' => $election->title]);

        return redirect()->route('vote.receipt');
    }

    // Show ballot receipt — one time, clears after viewing
    public function receipt()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $receipt  = session('vote_receipt');
        $election = session('receipt_election');

        if (!$receipt) {
            return redirect()->route('voter.dashboard');
        }

        // Clear receipt from session after viewing
        session()->forget(['vote_receipt', 'receipt_election']);

        return view('voter.receipt', compact('receipt', 'election'));
    }

    // Show results page
    public function results()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Get the most recent election that is ongoing or closed
        $election = Election::whereIn('status', ['ongoing', 'closed'])
                            ->latest()
                            ->first();

        if (!$election) {
            return redirect()->route('voter.dashboard')
                             ->with('error', 'No election results available yet.');
        }

        // Block if closed but not yet published
        if ($election->isClosed() && !$election->results_published) {
            return view('voter.results-pending', compact('election'));
        }

        // Build results per position
        $positions = $election->positions()
                              ->with(['candidates' => function ($q) {
                                  $q->where('status', 'approved')->with('user');
                              }])
                              ->orderBy('order')
                              ->get();

        $results = [];
        $totalVoters = \App\Models\User::count();
        $totalVoted  = Vote::where('election_id', $election->id)
                           ->distinct('user_id')
                           ->count('user_id');

        foreach ($positions as $position) {
            $positionVotes = [];
            $positionTotal = Vote::where('position_id', $position->id)->count();

            foreach ($position->candidates as $candidate) {
                $voteCount = Vote::where('candidate_id', $candidate->id)->count();
                $percentage = $positionTotal > 0
                    ? round(($voteCount / $positionTotal) * 100, 1)
                    : 0;

                $positionVotes[] = [
                    'candidate'  => $candidate->user->name,
                    'photo'      => $candidate->user->profile_photo,
                    'votes'      => $voteCount,
                    'percentage' => $percentage,
                ];
            }

            // Sort by votes descending
            usort($positionVotes, fn($a, $b) => $b['votes'] <=> $a['votes']);

            $results[] = [
                'position'     => $position->name,
                'max_winners'  => $position->max_winners,
                'total_votes'  => $positionTotal,
                'candidates'   => $positionVotes,
            ];
        }

        return view('voter.results', compact('election', 'results', 'totalVoters', 'totalVoted'));
    }
}