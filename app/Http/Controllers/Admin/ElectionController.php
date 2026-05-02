<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Election;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ElectionController extends Controller
{
    // Guard check helper
    private function guardCheck()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }
        return null;
    }

    // List all elections
    public function index()
    {
        if ($redirect = $this->guardCheck()) return $redirect;

        $elections = Election::latest()->get();

        return view('admin.elections.index', compact('elections'));
    }

    // Show create form
    public function create()
    {
        if ($redirect = $this->guardCheck()) return $redirect;

        // Business rule: only one active election at a time
        $hasActive = Election::whereIn('status', ['draft', 'ongoing'])->exists();

        return view('admin.elections.create', compact('hasActive'));
    }

    // Store new election
    public function store(Request $request)
    {
        if ($redirect = $this->guardCheck()) return $redirect;

        // Business rule: block if there's already an active election
        $hasActive = Election::whereIn('status', ['draft', 'ongoing'])->exists();

        if ($hasActive) {
            return back()->withErrors([
                'error' => 'There is already an active election. Close it before creating a new one.'
            ]);
        }

        $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_at'    => ['required', 'date', 'after:now'],
            'end_at'      => ['required', 'date', 'after:start_at'],
        ]);

        Election::create([
            'admin_id'    => Auth::guard('admin')->id(),
            'title'       => $request->title,
            'description' => $request->description,
            'start_at'    => $request->start_at,
            'end_at'      => $request->end_at,
            'status'      => 'draft',
        ]);

        return redirect()->route('admin.elections.index')
                         ->with('success', 'Election created successfully.');
    }

    // Show edit form
    public function edit(Election $election)
    {
        if ($redirect = $this->guardCheck()) return $redirect;

        // Cannot edit a closed election
        if ($election->isClosed()) {
            return redirect()->route('admin.elections.index')
                             ->with('error', 'Cannot edit a closed election.');
        }

        return view('admin.elections.edit', compact('election'));
    }

    // Update election
    public function update(Request $request, Election $election)
    {
        if ($redirect = $this->guardCheck()) return $redirect;

        if ($election->isClosed()) {
            return redirect()->route('admin.elections.index')
                             ->with('error', 'Cannot edit a closed election.');
        }

        $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_at'    => ['required', 'date'],
            'end_at'      => ['required', 'date', 'after:start_at'],
        ]);

        $election->update([
            'title'       => $request->title,
            'description' => $request->description,
            'start_at'    => $request->start_at,
            'end_at'      => $request->end_at,
        ]);

        return redirect()->route('admin.elections.index')
                         ->with('success', 'Election updated successfully.');
    }

    // Change election status
    public function updateStatus(Request $request, Election $election)
    {
        if ($redirect = $this->guardCheck()) return $redirect;

        $request->validate([
            'status' => ['required', 'in:ongoing,closed'],
        ]);

        $newStatus = $request->status;

        // draft → ongoing: check no other ongoing election
        if ($newStatus === 'ongoing') {
            $alreadyOngoing = Election::where('status', 'ongoing')
                                      ->where('id', '!=', $election->id)
                                      ->exists();
            if ($alreadyOngoing) {
                return back()->withErrors([
                    'error' => 'Another election is already ongoing.'
                ]);
            }

            // Must have at least one position before going ongoing
            if ($election->positions()->count() === 0) {
                return back()->withErrors([
                    'error' => 'Add at least one position before starting the election.'
                ]);
            }
        }

        // ongoing → closed only (cannot go backwards)
        if ($newStatus === 'ongoing' && !$election->isDraft()) {
            return back()->withErrors(['error' => 'Only draft elections can be set to ongoing.']);
        }

        if ($newStatus === 'closed' && !$election->isOngoing()) {
            return back()->withErrors(['error' => 'Only ongoing elections can be closed.']);
        }

        $election->update(['status' => $newStatus]);

        return redirect()->route('admin.elections.index')
                         ->with('success', 'Election status updated.');
    }

    // Publish results
    public function publishResults(Election $election)
    {
        if ($redirect = $this->guardCheck()) return $redirect;

        if (!$election->isClosed()) {
            return back()->withErrors(['error' => 'Election must be closed before publishing results.']);
        }

        $election->update(['results_published' => true]);

        return redirect()->route('admin.elections.index')
                         ->with('success', 'Results published successfully.');
    }
}