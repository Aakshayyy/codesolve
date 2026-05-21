<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Problem;
use App\Models\Tag;
use App\Models\TestCase as ProblemTestCase;
use App\Models\Submission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

class ProblemControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_problems_list(): void
    {
        Problem::create([
            'title' => 'Sum of Two', 'slug' => 'sum-of-two', 'difficulty' => 'easy',
            'description' => 'D', 'constraints' => 'C', 'input_format' => 'I', 'output_format' => 'O', 'time_limit' => 1000, 'memory_limit' => 256
        ]);

        $response = $this->get(route('problems.index'));

        $response->assertOk();
        $response->assertSee('Sum of Two');
    }

    public function test_guest_can_view_problem_details(): void
    {
        $problem = Problem::create([
            'title' => 'Sum of Two', 'slug' => 'sum-of-two', 'difficulty' => 'easy',
            'description' => 'D', 'constraints' => 'C', 'input_format' => 'I', 'output_format' => 'O', 'time_limit' => 1000, 'memory_limit' => 256
        ]);

        $response = $this->get(route('problems.show', $problem));

        $response->assertOk();
        $response->assertSee('Sum of Two');
        $response->assertSee('Easy');
    }

    public function test_problems_filtering_by_difficulty_and_search_and_tags(): void
    {
        $easy = Problem::create([
            'title' => 'Easy Problem One', 'slug' => 'easy-one', 'difficulty' => 'easy',
            'description' => 'D', 'constraints' => 'C', 'input_format' => 'I', 'output_format' => 'O', 'time_limit' => 1000, 'memory_limit' => 256
        ]);
        $hard = Problem::create([
            'title' => 'Hard Problem Two', 'slug' => 'hard-two', 'difficulty' => 'hard',
            'description' => 'D', 'constraints' => 'C', 'input_format' => 'I', 'output_format' => 'O', 'time_limit' => 1000, 'memory_limit' => 256
        ]);

        $tag = Tag::create(['name' => 'DP', 'slug' => 'dp']);
        $easy->tags()->attach($tag);

        // Filter by difficulty
        $response = $this->get(route('problems.index', ['difficulty' => 'easy']));
        $response->assertSee('Easy Problem One');
        $response->assertDontSee('Hard Problem Two');

        // Filter by search
        $response = $this->get(route('problems.index', ['search' => 'Hard']));
        $response->assertSee('Hard Problem Two');
        $response->assertDontSee('Easy Problem One');

        // Filter by tag
        $response = $this->get(route('problems.index', ['tag' => 'dp']));
        $response->assertSee('Easy Problem One');
        $response->assertDontSee('Hard Problem Two');
    }

    public function test_guest_cannot_run_or_submit_code(): void
    {
        $problem = Problem::create([
            'title' => 'Sum of Two', 'slug' => 'sum-of-two', 'difficulty' => 'easy',
            'description' => 'D', 'constraints' => 'C', 'input_format' => 'I', 'output_format' => 'O', 'time_limit' => 1000, 'memory_limit' => 256
        ]);

        $responseRun = $this->postJson(route('problems.run', $problem), [
            'language' => 'python',
            'code' => 'print(1)',
        ]);
        $responseRun->assertUnauthorized();

        $responseSubmit = $this->postJson(route('problems.submit', $problem), [
            'language' => 'python',
            'code' => 'print(1)',
        ]);
        $responseSubmit->assertUnauthorized();
    }

    public function test_user_can_run_code(): void
    {
        Http::fake([
            'https://emkc.org/api/v2/piston/execute' => Http::response([
                'run' => [
                    'code' => 0,
                    'stdout' => "run output\n",
                    'stderr' => '',
                ]
            ], 200)
        ]);

        $user = User::factory()->create();
        $problem = Problem::create([
            'title' => 'Sum of Two', 'slug' => 'sum-of-two', 'difficulty' => 'easy',
            'description' => 'D', 'constraints' => 'C', 'input_format' => 'I', 'output_format' => 'O', 'time_limit' => 1000, 'memory_limit' => 256
        ]);

        $response = $this->actingAs($user)->postJson(route('problems.run', $problem), [
            'language' => 'python',
            'code' => 'print("run output")',
            'input' => 'some input',
        ]);

        $response->assertOk();
        $response->assertJsonFragment([
            'status' => 'Success',
            'stdout' => "run output\n",
        ]);
    }

    public function test_user_can_submit_solution(): void
    {
        Http::fake([
            'https://emkc.org/api/v2/piston/execute' => Http::response([
                'run' => [
                    'code' => 0,
                    'stdout' => "expected output\n",
                    'stderr' => '',
                ]
            ], 200)
        ]);

        $user = User::factory()->create();
        $problem = Problem::create([
            'title' => 'Sum of Two', 'slug' => 'sum-of-two', 'difficulty' => 'easy',
            'description' => 'D', 'constraints' => 'C', 'input_format' => 'I', 'output_format' => 'O', 'time_limit' => 1000, 'memory_limit' => 256
        ]);

        ProblemTestCase::create([
            'problem_id' => $problem->id,
            'input' => 'input data',
            'expected_output' => 'expected output',
            'is_hidden' => false,
        ]);

        $response = $this->actingAs($user)->postJson(route('problems.submit', $problem), [
            'language' => 'python',
            'code' => 'print("expected output")',
        ]);

        $response->assertOk();
        $response->assertJsonFragment([
            'status' => 'Accepted',
        ]);

        $this->assertDatabaseHas('submissions', [
            'user_id' => $user->id,
            'problem_id' => $problem->id,
            'status' => 'Accepted',
            'language' => 'python',
        ]);
    }

    public function test_user_can_submit_solution_with_auto_driver_signature(): void
    {
        Http::fake([
            'https://emkc.org/api/v2/piston/execute' => Http::response([
                'run' => [
                    'code' => 0,
                    'stdout' => "0 1\n",
                    'stderr' => '',
                ]
            ], 200)
        ]);

        $user = User::factory()->create();
        // slug matches two-sum in signatures.php
        $problem = Problem::create([
            'title' => 'Two Sum', 'slug' => 'two-sum', 'difficulty' => 'easy',
            'description' => 'D', 'constraints' => 'C', 'input_format' => 'I', 'output_format' => 'O', 'time_limit' => 1000, 'memory_limit' => 256
        ]);

        ProblemTestCase::create([
            'problem_id' => $problem->id,
            'input' => "4\n2 7 11 15\n9",
            'expected_output' => '0 1',
            'is_hidden' => false,
        ]);

        // C++ code matching two-sum method signature
        $code = "class Solution {\npublic:\n    vector<int> twoSum(vector<int>& nums, int target) {\n        return {0, 1};\n    }\n};";

        $response = $this->actingAs($user)->postJson(route('problems.submit', $problem), [
            'language' => 'cpp',
            'code' => $code,
        ]);

        $response->assertOk();
        $response->assertJsonFragment([
            'status' => 'Accepted',
        ]);

        // Assert the original raw code is stored in the database
        $this->assertDatabaseHas('submissions', [
            'user_id' => $user->id,
            'problem_id' => $problem->id,
            'status' => 'Accepted',
            'language' => 'cpp',
            'code' => $code,
        ]);
    }
}
