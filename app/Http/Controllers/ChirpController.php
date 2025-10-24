<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChirpController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $chirps = Chirp::with('user')
            ->latest()
            ->take(50)
            ->get();

        return view('home', ['chirps' => $chirps]);
    }

    public function create()
    {
        //
    }

    // Store chirp
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        // Use auth user
        auth()->user()->chirps()->create($validated);

        return redirect('/')->with('success', 'Your chirp has been posted!');
    }

    // Display chirp
    public function show(string $id)
    {
        //
    }

    // Edit chirp
    public function edit(Chirp $chirp)
    {
        $this->authorize('update', $chirp);

        // Add authorization
        return view('chirps.edit', compact('chirp'));
    }

    /// Update chirp
    public function update(Request $request, Chirp $chirp)
    {
        $this->authorize('update', $chirp);

        // Validate
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        // Update
        $chirp->update($validated);

        return redirect('/')->with('success', 'Chirp updated!');
    }

    // Remove chirp
    public function destroy(Chirp $chirp)
    {
        $this->authorize('delete', $chirp);

        $chirp->delete();

        return redirect('/')->with('success', 'Chirp deleted!');
    }
}
