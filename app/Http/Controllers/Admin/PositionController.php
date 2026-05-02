<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Election;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PositionController extends Controller
{
    // Guard check helper
    private function guardCheck()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }
        return null;
    }

    // List all positions for a specific election
    public function index(Election $election)
    {
        if ($redirect = $this->guardCheck()) return $redirect;

        $positions = $election->positions()->orderBy('order')->get();

        return view('admin.positions.index', compact('election', 'positions'));
    }

    // Show create form
    public function create(Election $election)
    {
        if ($redirect = $this->guardCheck()) return $redirect;

        // Cannot add positions to a closed election
        if ($election->isClosed()) {
            return redirect()->route('admin.positions.index', $election)
                             ->with('error', 'Cannot add positions to a closed election.');
        }

        return view('admin.positions.create', compact('election'));
    }

    // Store new position
    public function store(Request $request, Election $election)
    {
        if ($redirect = $this->guardCheck()) return $redirect;

        if ($election->isClosed()) {
            return redirect()->route('admin.positions.index', $election)
                             ->with('error', 'Cannot add positions to a closed election.');
        }

        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'max_winners' => ['required', 'integer', 'min:1'],
            'order'       => ['required', 'integer', 'min:0'],
        ]);

        // Business rule: no duplicate position names in the same election
        $exists = Position::where('election_id', $election->id)
                          ->where('name', $request->name)
                          ->exists();

        if ($exists) {
            return back()->withErrors([
                'name' => 'A position with this name already exists in this election.'
            ])->withInput();
        }

        Position::create([
            'election_id' => $election->id,
            'name'        => $request->name,
            'max_winners' => $request->max_winners,
            'order'       => $request->order,
        ]);

        return redirect()->route('admin.positions.index', $election)
                         ->with('success', 'Position added successfully.');
    }

    // Show edit form
    public function edit(Election $election, Position $position)
    {
        if ($redirect = $this->guardCheck()) return $redirect;

        if ($election->isClosed()) {
            return redirect()->route('admin.positions.index', $election)
                             ->with('error', 'Cannot edit positions of a closed election.');
        }

        return view('admin.positions.edit', compact('election', 'position'));
    }

    // Update position
    public function update(Request $request, Election $election, Position $position)
    {
        if ($redirect = $this->guardCheck()) return $redirect;

        if ($election->isClosed()) {
            return redirect()->route('admin.positions.index', $election)
                             ->with('error', 'Cannot edit positions of a closed election.');
        }

        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'max_winners' => ['required', 'integer', 'min:1'],
            'order'       => ['required', 'integer', 'min:0'],
        ]);

        // Check duplicate name but exclude current position
        $exists = Position::where('election_id', $election->id)
                          ->where('name', $request->name)
                          ->where('id', '!=', $position->id)
                          ->exists();

        if ($exists) {
            return back()->withErrors([
                'name' => 'A position with this name already exists in this election.'
            ])->withInput();
        }

        $position->update([
            'name'        => $request->name,
            'max_winners' => $request->max_winners,
            'order'       => $request->order,
        ]);

        return redirect()->route('admin.positions.index', $election)
                         ->with('success', 'Position updated successfully.');
    }

    // Delete position
    public function destroy(Election $election, Position $position)
    {
        if ($redirect = $this->guardCheck()) return $redirect;

        // Cannot delete if election is ongoing or closed
        if (!$election->isDraft()) {
            return redirect()->route('admin.positions.index', $election)
                             ->with('error', 'Cannot delete positions once election has started.');
        }

        $position->delete();

        return redirect()->route('admin.positions.index', $election)
                         ->with('success', 'Position deleted.');
    }
}