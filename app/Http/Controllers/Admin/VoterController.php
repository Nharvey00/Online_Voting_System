<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class VoterController extends Controller
{
    private function guardCheck()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }
        return null;
    }

    // List all voters
    public function index()
    {
        if ($redirect = $this->guardCheck()) return $redirect;

        $voters = User::latest()->get();

        return view('admin.voters.index', compact('voters'));
    }

    // View a single voter's details
    public function show(User $user)
    {
        if ($redirect = $this->guardCheck()) return $redirect;

        $application = $user->candidates()->with(['election', 'position'])->latest()->first();

        return view('admin.voters.show', compact('user', 'application'));
    }
}