<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Election;
use App\Models\Vote;
use App\Models\User;
use App\Models\Candidate;
use Illuminate\Support\Facades\Auth;

class ResultsController extends Controller
{
    private function guardCheck()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }
        return null;
    }

    public function index()
    {
        if ($redirect = $this->guardCheck()) return $redirect;

        $election = Election::whereIn('status', ['ongoing', 'closed'])->latest()->first();

        if (!$election) {
            return view('admin.results.index', [
                'election'    => null,
                'results'     => [],
                'totalVoters' => 0,
                'totalVoted'  => 0,
            ]);
        }

        $positions = $election->positions()
                              ->with(['candidates' => function ($q) {
                                  $q->where('status', 'approved')->with('user');
                              }])
                              ->orderBy('order')
                              ->get();

        $results     = [];
        $totalVoters = User::count();
        $totalVoted  = Vote::where('election_id', $election->id)
                           ->distinct('user_id')
                           ->count('user_id');

        foreach ($positions as $position) {
            $positionVotes = [];
            $positionTotal = Vote::where('position_id', $position->id)->count();

            foreach ($position->candidates as $candidate) {
                $voteCount  = Vote::where('candidate_id', $candidate->id)->count();
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

            usort($positionVotes, fn($a, $b) => $b['votes'] <=> $a['votes']);

            $results[] = [
                'position'    => $position->name,
                'max_winners' => $position->max_winners,
                'total_votes' => $positionTotal,
                'candidates'  => $positionVotes,
            ];
        }

        return view('admin.results.index', compact(
            'election',
            'results',
            'totalVoters',
            'totalVoted'
        ));
    }
}