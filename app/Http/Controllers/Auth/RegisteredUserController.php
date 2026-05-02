<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    // Show registration form
    public function create(): View
    {
        return view('auth.register');
    }

    // Handle registration form submission
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'      => ['required', 'confirmed'],
            'birthdate'     => ['required', 'date', 'before:' . now()->subYears(18)->toDateString()],
            'address'       => ['required', 'string', 'max:255'],
            'barangay'      => ['required', 'string', 'max:255'],
            'city'          => ['required', 'string', 'max:255'],
            'province'      => ['required', 'string', 'max:255'],
            'id_type'       => ['required', 'string', 'in:PhilSys,Passport,Drivers License,UMID,PRC ID,Postal ID,Senior Citizen ID,PWD ID,Voter ID'],
            'id_number'     => ['required', 'string', 'max:255'],
            'id_photo'      => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'profile_photo' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ], [
            'birthdate.before' => 'You must be at least 18 years old to register.',
        ]);

        // Store uploaded files
        $idPhotoPath      = $request->file('id_photo')->store('id_photos', 'public');
        $profilePhotoPath = $request->file('profile_photo')->store('profile_photos', 'public');

        $user = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'birthdate'     => $request->birthdate,
            'address'       => $request->address,
            'barangay'      => $request->barangay,
            'city'          => $request->city,
            'province'      => $request->province,
            'id_type'       => $request->id_type,
            'id_number'     => $request->id_number,
            'id_photo'      => $idPhotoPath,
            'profile_photo' => $profilePhotoPath,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('voter.dashboard');
    }
}