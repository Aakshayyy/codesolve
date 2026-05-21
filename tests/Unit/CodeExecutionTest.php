<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Problem;
use App\Models\TestCase as ProblemTestCase;
use App\Models\Badge;
use App\Models\Submission;
use App\Services\CodeExecutionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class CodeExecutionTest extends TestCase
{
    use RefreshDatabase;

    private CodeExecutionService $codeExecutionService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->codeExecutionService = new CodeExecutionService();
    }

    public function test_run_code_piston_success(): void
    {
        Http::fake([
            'https://emkc.org/api/v2/piston/execute' => Http::response([
                'run' => [
                    'code' => 0,
                    'stdout' => "hello world\n",
                    'stderr' => '',
                ]
            ], 200)
        ]);

        $problem = Problem::create([
            'title' => 'Test Problem',
            'slug' => 'test-problem',
            'description' => 'Desc',
            'difficulty' => 'easy',
            'constraints' => 'None',
            'input_format' => 'None',
            'output_format' => 'None',
            'time_limit' => 1000,
            'memory_limit' => 256,
        ]);

        $result = $this->codeExecutionService->runCode($problem, 'python', 'print("hello world")', 'input_data');

        $this->assertEquals('Success', $result['status']);
        $this->assertEquals("hello world\n", $result['stdout']);
        $this->assertEmpty($result['stderr']);
        $this->assertGreaterThan(0, $result['time']);
        $this->assertGreaterThan(0, $result['memory']);
    }

    public function test_run_code_piston_compile_error(): void
    {
        Http::fake([
            'https://emkc.org/api/v2/piston/execute' => Http::response([
                'compile' => [
                    'code' => 1,
                    'output' => "Syntax error on line 1",
                ]
            ], 200)
        ]);

        $problem = Problem::create([
            'title' => 'Test Problem',
            'slug' => 'test-problem',
            'description' => 'Desc',
            'difficulty' => 'easy',
            'constraints' => 'None',
            'input_format' => 'None',
            'output_format' => 'None',
            'time_limit' => 1000,
            'memory_limit' => 256,
        ]);

        $result = $this->codeExecutionService->runCode($problem, 'python', 'invalid code', 'input_data');

        $this->assertEquals('Compile Error', $result['status']);
        $this->assertEquals('Syntax error on line 1', $result['stderr']);
    }

    public function test_run_code_piston_runtime_error(): void
    {
        Http::fake([
            'https://emkc.org/api/v2/piston/execute' => Http::response([
                'run' => [
                    'code' => 1,
                    'stderr' => "ZeroDivisionError: division by zero",
                ]
            ], 200)
        ]);

        $problem = Problem::create([
            'title' => 'Test Problem',
            'slug' => 'test-problem',
            'description' => 'Desc',
            'difficulty' => 'easy',
            'constraints' => 'None',
            'input_format' => 'None',
            'output_format' => 'None',
            'time_limit' => 1000,
            'memory_limit' => 256,
        ]);

        $result = $this->codeExecutionService->runCode($problem, 'python', '1/0', 'input_data');

        $this->assertEquals('Runtime Error', $result['status']);
        $this->assertEquals('ZeroDivisionError: division by zero', $result['stderr']);
    }

    public function test_run_code_piston_time_limit_exceeded(): void
    {
        // Test with SIGKILL signal
        Http::fake([
            'https://emkc.org/api/v2/piston/execute' => Http::response([
                'run' => [
                    'code' => 1,
                    'stderr' => 'Killed',
                    'signal' => 'SIGKILL'
                ]
            ], 200)
        ]);

        $problem = Problem::create([
            'title' => 'Test Problem',
            'slug' => 'test-problem',
            'description' => 'Desc',
            'difficulty' => 'easy',
            'constraints' => 'None',
            'input_format' => 'None',
            'output_format' => 'None',
            'time_limit' => 1000,
            'memory_limit' => 256,
        ]);

        $result = $this->codeExecutionService->runCode($problem, 'python', 'while True: pass', 'input_data');

        $this->assertEquals('Time Limit Exceeded', $result['status']);
    }

    public function test_run_code_fallback_to_mock_when_piston_fails(): void
    {
        // Force Http to return a server error
        Http::fake([
            'https://emkc.org/api/v2/piston/execute' => Http::response([], 500)
        ]);

        $problem = Problem::create([
            'title' => 'Test Problem',
            'slug' => 'test-problem',
            'description' => 'Desc',
            'difficulty' => 'easy',
            'constraints' => 'None',
            'input_format' => 'None',
            'output_format' => 'None',
            'time_limit' => 1000,
            'memory_limit' => 256,
        ]);

        ProblemTestCase::create([
            'problem_id' => $problem->id,
            'input' => "test_input",
            'expected_output' => "test_output",
            'is_hidden' => false,
        ]);

        // Code should be long enough and look like code, otherwise it throws mock Compile Error
        $code = "def solution():\n    return 'test_output'";
        $result = $this->codeExecutionService->runCode($problem, 'python', $code, 'test_input');

        $this->assertEquals('Success', $result['status']);
        $this->assertEquals('test_output', $result['stdout']);
    }

    public function test_submit_solution_accepted_and_awards_points_and_streak(): void
    {
        Http::fake([
            'https://emkc.org/api/v2/piston/execute' => Http::response([
                'run' => [
                    'code' => 0,
                    'stdout' => "test_output\n",
                    'stderr' => '',
                ]
            ], 200)
        ]);

        $user = User::factory()->create([
            'points' => 0,
            'streak' => 1,
            'last_submission_at' => Carbon::now()->subDay(),
        ]);

        $problem = Problem::create([
            'title' => 'Test Problem',
            'slug' => 'test-problem',
            'description' => 'Desc',
            'difficulty' => 'medium',
            'constraints' => 'None',
            'input_format' => 'None',
            'output_format' => 'None',
            'time_limit' => 1000,
            'memory_limit' => 256,
        ]);

        ProblemTestCase::create([
            'problem_id' => $problem->id,
            'input' => "test_input",
            'expected_output' => "test_output",
            'is_hidden' => false,
        ]);

        $code = "def solution():\n    return 'test_output'";
        $submission = $this->codeExecutionService->submitSolution($user, $problem, 'python', $code);

        $this->assertEquals('Accepted', $submission->status);
        $this->assertEquals('medium', $problem->difficulty);

        $user->refresh();
        // Medium problem awards 20 points
        $this->assertEquals(20, $user->points);
        // Solved consecutive day, streak increments to 2
        $this->assertEquals(2, $user->streak);
        $this->assertNotNull($user->last_submission_at);
    }

    public function test_points_by_difficulty(): void
    {
        Http::fake([
            'https://emkc.org/api/v2/piston/execute' => Http::response([
                'run' => [
                    'code' => 0,
                    'stdout' => "ans\n",
                    'stderr' => '',
                ]
            ], 200)
        ]);

        $code = "def solution():\n    return 'ans'";

        // Easy Problem: 10 points
        $user1 = User::factory()->create(['points' => 0]);
        $problem1 = Problem::create([
            'title' => 'Easy Problem', 'slug' => 'easy-prob', 'difficulty' => 'easy',
            'description' => 'D', 'constraints' => 'C', 'input_format' => 'I', 'output_format' => 'O', 'time_limit' => 1000, 'memory_limit' => 256
        ]);
        ProblemTestCase::create(['problem_id' => $problem1->id, 'input' => 'in', 'expected_output' => 'ans']);
        $this->codeExecutionService->submitSolution($user1, $problem1, 'python', $code);
        $user1->refresh();
        $this->assertEquals(10, $user1->points);

        // Hard Problem: 30 points
        $user2 = User::factory()->create(['points' => 0]);
        $problem2 = Problem::create([
            'title' => 'Hard Problem', 'slug' => 'hard-prob', 'difficulty' => 'hard',
            'description' => 'D', 'constraints' => 'C', 'input_format' => 'I', 'output_format' => 'O', 'time_limit' => 1000, 'memory_limit' => 256
        ]);
        ProblemTestCase::create(['problem_id' => $problem2->id, 'input' => 'in', 'expected_output' => 'ans']);
        $this->codeExecutionService->submitSolution($user2, $problem2, 'python', $code);
        $user2->refresh();
        $this->assertEquals(30, $user2->points);
    }

    public function test_points_not_awarded_twice_for_same_problem(): void
    {
        Http::fake([
            'https://emkc.org/api/v2/piston/execute' => Http::response([
                'run' => [
                    'code' => 0,
                    'stdout' => "ans\n",
                    'stderr' => '',
                ]
            ], 200)
        ]);

        $user = User::factory()->create(['points' => 0]);
        $problem = Problem::create([
            'title' => 'Easy Problem', 'slug' => 'easy-prob', 'difficulty' => 'easy',
            'description' => 'D', 'constraints' => 'C', 'input_format' => 'I', 'output_format' => 'O', 'time_limit' => 1000, 'memory_limit' => 256
        ]);
        ProblemTestCase::create(['problem_id' => $problem->id, 'input' => 'in', 'expected_output' => 'ans']);
        
        $code = "def solution():\n    return 'ans'";

        // First submit: Accepted, +10 points
        $this->codeExecutionService->submitSolution($user, $problem, 'python', $code);
        $user->refresh();
        $this->assertEquals(10, $user->points);

        // Second submit: Accepted, should remain 10 points
        $this->codeExecutionService->submitSolution($user, $problem, 'python', $code);
        $user->refresh();
        $this->assertEquals(10, $user->points);
    }

    public function test_streak_logic_variations(): void
    {
        Http::fake([
            'https://emkc.org/api/v2/piston/execute' => Http::response([
                'run' => [
                    'code' => 0,
                    'stdout' => "ans\n",
                    'stderr' => '',
                ]
            ], 200)
        ]);

        $problem = Problem::create([
            'title' => 'Easy Problem', 'slug' => 'easy-prob', 'difficulty' => 'easy',
            'description' => 'D', 'constraints' => 'C', 'input_format' => 'I', 'output_format' => 'O', 'time_limit' => 1000, 'memory_limit' => 256
        ]);
        ProblemTestCase::create(['problem_id' => $problem->id, 'input' => 'in', 'expected_output' => 'ans']);
        $code = "def solution():\n    return 'ans'";

        // Case 1: First ever submission -> streak = 1
        $user1 = User::factory()->create(['streak' => 0, 'last_submission_at' => null]);
        $this->codeExecutionService->submitSolution($user1, $problem, 'python', $code);
        $user1->refresh();
        $this->assertEquals(1, $user1->streak);

        // Case 2: Last submission was today -> streak unchanged
        $user2 = User::factory()->create(['streak' => 3, 'last_submission_at' => Carbon::now()]);
        $this->codeExecutionService->submitSolution($user2, $problem, 'python', $code);
        $user2->refresh();
        $this->assertEquals(3, $user2->streak);

        // Case 3: Last submission was more than a day ago -> streak reset to 1
        $user3 = User::factory()->create(['streak' => 5, 'last_submission_at' => Carbon::now()->subDays(2)]);
        $this->codeExecutionService->submitSolution($user3, $problem, 'python', $code);
        $user3->refresh();
        $this->assertEquals(1, $user3->streak);
    }

    public function test_submit_solution_wrong_answer(): void
    {
        Http::fake([
            'https://emkc.org/api/v2/piston/execute' => Http::response([
                'run' => [
                    'code' => 0,
                    'stdout' => "wrong_output\n",
                    'stderr' => '',
                ]
            ], 200)
        ]);

        $user = User::factory()->create([
            'points' => 0,
        ]);

        $problem = Problem::create([
            'title' => 'Test Problem',
            'slug' => 'test-problem',
            'description' => 'Desc',
            'difficulty' => 'easy',
            'constraints' => 'None',
            'input_format' => 'None',
            'output_format' => 'None',
            'time_limit' => 1000,
            'memory_limit' => 256,
        ]);

        ProblemTestCase::create([
            'problem_id' => $problem->id,
            'input' => "test_input",
            'expected_output' => "test_output",
            'is_hidden' => false,
        ]);

        $code = "def solution():\n    return 'wrong_output'";
        $submission = $this->codeExecutionService->submitSolution($user, $problem, 'python', $code);

        $this->assertEquals('Wrong Answer', $submission->status);

        $user->refresh();
        $this->assertEquals(0, $user->points);
    }

    public function test_badge_awarded_upon_solving(): void
    {
        Http::fake([
            'https://emkc.org/api/v2/piston/execute' => Http::response([
                'run' => [
                    'code' => 0,
                    'stdout' => "test_output\n",
                    'stderr' => '',
                ]
            ], 200)
        ]);

        // Create Badges
        $badgeSolved = Badge::create([
            'name' => 'First Blood',
            'description' => 'Solve 1 problem',
            'icon' => 'trophy',
            'requirement_type' => 'solved_count',
            'requirement_value' => 1,
        ]);

        $user = User::factory()->create([
            'points' => 0,
        ]);

        $problem = Problem::create([
            'title' => 'Test Problem',
            'slug' => 'test-problem',
            'description' => 'Desc',
            'difficulty' => 'easy',
            'constraints' => 'None',
            'input_format' => 'None',
            'output_format' => 'None',
            'time_limit' => 1000,
            'memory_limit' => 256,
        ]);

        ProblemTestCase::create([
            'problem_id' => $problem->id,
            'input' => "test_input",
            'expected_output' => "test_output",
            'is_hidden' => false,
        ]);

        $code = "def solution():\n    return 'test_output'";
        
        $this->assertEquals(0, $user->badges()->count());

        $this->codeExecutionService->submitSolution($user, $problem, 'python', $code);

        $user->refresh();
        $this->assertEquals(1, $user->badges()->count());
        $this->assertEquals($badgeSolved->id, $user->badges()->first()->id);
    }
}
