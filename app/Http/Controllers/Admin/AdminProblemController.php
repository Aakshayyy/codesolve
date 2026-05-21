<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Problem;
use App\Models\Tag;
use App\Models\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProblemController extends Controller
{
    /**
     * Display a listing of problems.
     */
    public function index()
    {
        $problems = Problem::with('tags')->latest()->paginate(15);
        return view('admin.problems.index', compact('problems'));
    }

    /**
     * Show the form for creating a new problem.
     */
    public function create()
    {
        $tags = Tag::all();
        return view('admin.problems.create', compact('tags'));
    }

    /**
     * Store a newly created problem.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'difficulty' => 'required|in:easy,medium,hard',
            'constraints' => 'nullable|string',
            'input_format' => 'nullable|string',
            'output_format' => 'nullable|string',
            'time_limit' => 'required|integer|min:100|max:10000',
            'memory_limit' => 'required|integer|min:16|max:1024',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'test_cases' => 'required|array|min:1',
            'test_cases.*.input' => 'nullable|string',
            'test_cases.*.expected_output' => 'required|string',
            'test_cases.*.is_hidden' => 'nullable|boolean',
        ]);

        $problem = Problem::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'description' => $validated['description'],
            'difficulty' => $validated['difficulty'],
            'constraints' => $validated['constraints'] ?? null,
            'input_format' => $validated['input_format'] ?? null,
            'output_format' => $validated['output_format'] ?? null,
            'time_limit' => $validated['time_limit'],
            'memory_limit' => $validated['memory_limit'],
        ]);

        // Sync tags
        if (!empty($validated['tags'])) {
            $problem->tags()->sync($validated['tags']);
        }

        // Add test cases
        foreach ($validated['test_cases'] as $tcData) {
            $problem->testCases()->create([
                'input' => $tcData['input'] ?? '',
                'expected_output' => $tcData['expected_output'],
                'is_hidden' => isset($tcData['is_hidden']) ? (bool)$tcData['is_hidden'] : false,
            ]);
        }

        return redirect()->route('admin.problems.index')->with('success', 'Problem created successfully.');
    }

    /**
     * Show the form for editing the specified problem.
     */
    public function edit(Problem $problem)
    {
        $tags = Tag::all();
        $problem->load(['tags', 'testCases']);
        return view('admin.problems.edit', compact('problem', 'tags'));
    }

    /**
     * Update the specified problem in storage.
     */
    public function update(Request $request, Problem $problem)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'difficulty' => 'required|in:easy,medium,hard',
            'constraints' => 'nullable|string',
            'input_format' => 'nullable|string',
            'output_format' => 'nullable|string',
            'time_limit' => 'required|integer|min:100|max:10000',
            'memory_limit' => 'required|integer|min:16|max:1024',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'test_cases' => 'required|array|min:1',
            'test_cases.*.input' => 'nullable|string',
            'test_cases.*.expected_output' => 'required|string',
            'test_cases.*.is_hidden' => 'nullable|boolean',
        ]);

        $problem->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'description' => $validated['description'],
            'difficulty' => $validated['difficulty'],
            'constraints' => $validated['constraints'] ?? null,
            'input_format' => $validated['input_format'] ?? null,
            'output_format' => $validated['output_format'] ?? null,
            'time_limit' => $validated['time_limit'],
            'memory_limit' => $validated['memory_limit'],
        ]);

        // Sync tags
        $problem->tags()->sync($request->input('tags', []));

        // Sync test cases (delete old ones and recreate to keep code simple and robust)
        $problem->testCases()->delete();
        foreach ($validated['test_cases'] as $tcData) {
            $problem->testCases()->create([
                'input' => $tcData['input'] ?? '',
                'expected_output' => $tcData['expected_output'],
                'is_hidden' => isset($tcData['is_hidden']) ? (bool)$tcData['is_hidden'] : false,
            ]);
        }

        return redirect()->route('admin.problems.index')->with('success', 'Problem updated successfully.');
    }

    /**
     * Remove the specified problem from storage.
     */
    public function destroy(Problem $problem)
    {
        $problem->delete();
        return redirect()->route('admin.problems.index')->with('success', 'Problem deleted successfully.');
    }
}
