<?php

namespace App\Http\Controllers;

use App\Models\PendingRateUpdate;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PendingRateUpdateController extends Controller
{
    /**
     * Display a listing of pending rate updates (admin only).
     */
    public function index()
    {
        Gate::authorize('viewAny', PendingRateUpdate::class);

        return view('pending-rate-updates.index', [
            'pendingUpdates' => PendingRateUpdate::where('status', 'pending')
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new pending rate update.
     */
    public function create()
    {
        Gate::authorize('create', PendingRateUpdate::class);

        return view('pending-rate-updates.create');
    }

    /**
     * Store a newly created pending rate update.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', PendingRateUpdate::class);

        $validated = $request->validate([
            'province' => 'required|string|max:2',
            'start' => 'required|date',
            'pst' => 'required|numeric|min:0',
            'gst' => 'required|numeric|min:0',
            'hst' => 'required|numeric|min:0',
            'applicable' => 'required|numeric|min:0',
            'type' => 'required|string',
            'source' => 'required|string',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        PendingRateUpdate::create($validated);

        return redirect()->route('dashboard')->with('success', 'Rate update proposal submitted successfully. It will be reviewed by an administrator.');
    }

    /**
     * Display the specified pending rate update for review (admin only).
     */
    public function show(PendingRateUpdate $pendingRateUpdate)
    {
        Gate::authorize('review', $pendingRateUpdate);

        return view('pending-rate-updates.show', [
            'pendingUpdate' => $pendingRateUpdate->load('user'),
        ]);
    }

    /**
     * Approve a pending rate update (admin only).
     */
    public function approve(Request $request, PendingRateUpdate $pendingRateUpdate)
    {
        Gate::authorize('review', $pendingRateUpdate);

        if ($pendingRateUpdate->status !== 'pending') {
            return redirect()->route('pending-rate-updates.index')
                ->with('error', 'This update has already been reviewed.');
        }

        $validated = $request->validate([
            'review_notes' => 'nullable|string',
        ]);

        // Create the actual rate from the pending update
        Rate::create([
            'province' => $pendingRateUpdate->province,
            'pst' => $pendingRateUpdate->pst,
            'gst' => $pendingRateUpdate->gst,
            'hst' => $pendingRateUpdate->hst,
            'applicable' => $pendingRateUpdate->applicable,
            'type' => $pendingRateUpdate->type,
            'start' => $pendingRateUpdate->start,
            'source' => $pendingRateUpdate->source,
        ]);

        // Update the pending rate update status
        $pendingRateUpdate->update([
            'status' => 'approved',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'review_notes' => $validated['review_notes'] ?? null,
        ]);

        return redirect()->route('pending-rate-updates.index')
            ->with('success', 'Rate update approved and published successfully.');
    }

    /**
     * Reject a pending rate update (admin only).
     */
    public function reject(Request $request, PendingRateUpdate $pendingRateUpdate)
    {
        Gate::authorize('review', $pendingRateUpdate);

        if ($pendingRateUpdate->status !== 'pending') {
            return redirect()->route('pending-rate-updates.index')
                ->with('error', 'This update has already been reviewed.');
        }

        $validated = $request->validate([
            'review_notes' => 'required|string',
        ]);

        $pendingRateUpdate->update([
            'status' => 'rejected',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'review_notes' => $validated['review_notes'],
        ]);

        return redirect()->route('pending-rate-updates.index')
            ->with('success', 'Rate update rejected.');
    }
}
