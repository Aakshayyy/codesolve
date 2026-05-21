<?php

namespace App\Http\Controllers;

use App\Models\Problem;
use App\Models\Tag;
use App\Models\Submission;
use App\Services\CodeExecutionService;
use Illuminate\Http\Request;

class ProblemController extends Controller
{
    protected $executionService;

    public function __construct(CodeExecutionService $executionService)
    {
        $this->executionService = $executionService;
    }

    /**
     * Display a listing of problems with search, difficulty, and tag filters.
     */
    public function index(Request $request)
    {
        $query = Problem::with('tags');

        // Search filter
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Difficulty filter
        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        // Tag filter
        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('slug', $request->tag);
            });
        }

        // Solved/Unsolved filter
        if ($request->filled('status') && auth()->check()) {
            $userId = auth()->id();
            if ($request->status === 'solved') {
                $query->whereIn('id', function ($q) use ($userId) {
                    $q->select('problem_id')
                        ->from('submissions')
                        ->where('user_id', $userId)
                        ->where('status', 'Accepted');
                });
            } elseif ($request->status === 'unsolved') {
                $query->whereNotIn('id', function ($q) use ($userId) {
                    $q->select('problem_id')
                        ->from('submissions')
                        ->where('user_id', $userId)
                        ->where('status', 'Accepted');
                });
            }
        }

        $problems = $query->latest()->paginate(15)->withQueryString();
        $tags = Tag::all();

        // Calculate solve status mapping for the logged in user
        $userSolveStatus = [];
        if (auth()->check()) {
            $userId = auth()->id();
            $submissions = Submission::where('user_id', $userId)
                ->select('problem_id', 'status')
                ->get()
                ->groupBy('problem_id');

            foreach ($submissions as $probId => $subs) {
                if ($subs->contains('status', 'Accepted')) {
                    $userSolveStatus[$probId] = 'solved';
                } else {
                    $userSolveStatus[$probId] = 'attempted';
                }
            }
        }

        return view('problems.index', compact('problems', 'tags', 'userSolveStatus'));
    }

    /**
     * Display the problem workspace with code editor.
     */
    public function show(Problem $problem, Request $request)
    {
        $problem->load(['tags', 'testCases' => function ($q) {
            $q->where('is_hidden', false);
        }, 'comments.user', 'comments.replies.user']);

        $contestId = $request->query('contest_id');
        
        // Default codes for quick startup in Monaco Editor
        $defaultCodes = [
            'cpp' => "#include <iostream>\nusing namespace std;\n\nint main() {\n    // Write your C++ code here\n    return 0;\n}",
            'java' => "import java.util.*;\n\npublic class Main {\n    public static void main(String[] args) {\n        // Write your Java code here\n    }\n}",
            'python' => "# Write your Python code here\n",
            'javascript' => "// Write your JavaScript (Node.js) code here\n",
        ];

        $defaultCodes = \App\Services\SignatureService::generateStarterCodes($problem, $defaultCodes);

        return view('problems.show', compact('problem', 'defaultCodes', 'contestId'));
    }

    /**
     * Run user code against custom input.
     */
    public function run(Request $request, Problem $problem)
    {
        $validated = $request->validate([
            'language' => 'required|string|in:cpp,java,python,javascript',
            'code' => 'required|string',
            'input' => 'nullable|string',
        ]);

        $result = $this->executionService->runCode(
            $problem,
            $validated['language'],
            $validated['code'],
            $validated['input'] ?? ''
        );

        return response()->json($result);
    }

    /**
     * Submit user code for grading.
     */
    public function submit(Request $request, Problem $problem)
    {
        $validated = $request->validate([
            'language' => 'required|string|in:cpp,java,python,javascript',
            'code' => 'required|string',
            'contest_id' => 'nullable|exists:contests,id',
        ]);

        $submission = $this->executionService->submitSolution(
            auth()->user(),
            $problem,
            $validated['language'],
            $validated['code'],
            $validated['contest_id'] ?? null
        );

        return response()->json([
            'status' => $submission->status,
            'execution_time' => $submission->execution_time,
            'memory_used' => $submission->memory_used,
            'created_at' => $submission->created_at->diffForHumans()
        ]);
    }
}
