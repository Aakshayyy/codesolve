<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\Problem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminContestController extends Controller
{
    /**
     * Display a listing of contests.
     */
    public function index()
    {
        $contests = Contest::latest()->paginate(10);
        return view('admin.contests.index', compact('contests'));
    }

    /**
     * Show the form for creating a new contest.
     */
    public function create()
    {
        $problems = Problem::all();
        return view('admin.contests.create', compact('problems'));
    }

    /**
     * Store a newly created contest.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date|after_or_equal:now',
            'end_time' => 'required|date|after:start_time',
            'problems' => 'required|array|min:1',
            'problems.*' => 'exists:problems,id',
            'points' => 'required|array',
            'points.*' => 'required|integer|min:1',
        ]);

        $contest = Contest::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'description' => $validated['description'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
        ]);

        // Attach problems with points
        $syncData = [];
        foreach ($validated['problems'] as $problemId) {
            $points = $validated['points'][$problemId] ?? 100;
            $syncData[$problemId] = ['points' => $points];
        }
        $contest->problems()->sync($syncData);

        return redirect()->route('admin.contests.index')->with('success', 'Contest created successfully.');
    }

    /**
     * Show the form for editing the specified contest.
     */
    public function edit(Contest $contest)
    {
        $problems = Problem::all();
        $contest->load('problems');
        return view('admin.contests.edit', compact('contest', 'problems'));
    }

    /**
     * Update the specified contest in storage.
     */
    public function update(Request $request, Contest $contest)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'problems' => 'required|array|min:1',
            'problems.*' => 'exists:problems,id',
            'points' => 'required|array',
            'points.*' => 'required|integer|min:1',
        ]);

        $contest->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'description' => $validated['description'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
        ]);

        // Sync problems with points
        $syncData = [];
        foreach ($validated['problems'] as $problemId) {
            $points = $validated['points'][$problemId] ?? 100;
            $syncData[$problemId] = ['points' => $points];
        }
        $contest->problems()->sync($syncData);

        return redirect()->route('admin.contests.index')->with('success', 'Contest updated successfully.');
    }

    /**
     * Remove the specified contest from storage.
     */
    public function destroy(Contest $contest)
    {
        $contest->delete();
        return redirect()->route('admin.contests.index')->with('success', 'Contest deleted successfully.');
    }
}
