<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Election;
use App\Models\Candidate;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        $admin = Auth::guard('admin')->user();

        // Total registered voters
        $totalVoters = User::count();

        // Active election (draft or ongoing)
        $activeElection = Election::whereIn('status', ['draft', 'ongoing'])->first();

        // Pending candidate applications
        $pendingApplications = Candidate::where('status', 'pending')->count();

        // Total votes cast in active election
        $totalVotesCast = 0;
        if ($activeElection) {
            $totalVotesCast = Vote::where('election_id', $activeElection->id)
                                  ->distinct('user_id')
                                  ->count('user_id');
        }

        // Recent applications (last 5)
        $recentApplications = Candidate::with(['user', 'position', 'election'])
                                        ->latest()
                                        ->take(5)
                                        ->get();

        return view('admin.dashboard', compact(
            'admin',
            'totalVoters',
            'activeElection',
            'pendingApplications',
            'totalVotesCast',
            'recentApplications'
        ));
    }
}