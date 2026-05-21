<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Problem;
use App\Models\Contest;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminProblemTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->user = User::factory()->create(['role' => 'user']);
    }

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function test_non_admin_cannot_access_admin_dashboard(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.dashboard'));
        $response->assertStatus(403);
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));
        $response->assertOk();
    }

    public function test_admin_can_toggle_user_roles(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.users.toggle-role', $this->user->id));

        $response->assertRedirect();
        $this->user->refresh();
        $this->assertEquals('admin', $this->user->role);
    }

    public function test_admin_cannot_toggle_own_role(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.users.toggle-role', $this->admin->id));

        $response->assertRedirect();
        $this->admin->refresh();
        $this->assertEquals('admin', $this->admin->role);
    }

    public function test_admin_can_delete_users(): void
    {
        $response = $this->actingAs($this->admin)->delete(route('admin.users.destroy', $this->user->id));

        $response->assertRedirect();
        $this->assertDatabaseMissing('users', ['id' => $this->user->id]);
    }

    public function test_admin_cannot_delete_themself(): void
    {
        $response = $this->actingAs($this->admin)->delete(route('admin.users.destroy', $this->admin->id));

        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
    }

    public function test_admin_can_create_problem_with_test_cases(): void
    {
        $tag = Tag::create(['name' => 'Recursion', 'slug' => 'recursion']);

        $response = $this->actingAs($this->admin)->post(route('admin.problems.store'), [
            'title' => 'New Unique Problem',
            'description' => 'A unique problem description',
            'difficulty' => 'hard',
            'constraints' => 'None',
            'input_format' => 'Input',
            'output_format' => 'Output',
            'time_limit' => 2000,
            'memory_limit' => 512,
            'tags' => [$tag->id],
            'test_cases' => [
                [
                    'input' => 'case1_in',
                    'expected_output' => 'case1_out',
                    'is_hidden' => 0,
                ],
                [
                    'input' => 'case2_in',
                    'expected_output' => 'case2_out',
                    'is_hidden' => 1,
                ]
            ]
        ]);

        $response->assertRedirect(route('admin.problems.index'));
        $this->assertDatabaseHas('problems', [
            'title' => 'New Unique Problem',
            'difficulty' => 'hard',
        ]);

        $problem = Problem::where('title', 'New Unique Problem')->first();
        $this->assertNotNull($problem);
        $this->assertEquals(2, $problem->testCases()->count());
        $this->assertDatabaseHas('test_cases', [
            'problem_id' => $problem->id,
            'input' => 'case1_in',
            'expected_output' => 'case1_out',
            'is_hidden' => false,
        ]);
        $this->assertDatabaseHas('test_cases', [
            'problem_id' => $problem->id,
            'input' => 'case2_in',
            'expected_output' => 'case2_out',
            'is_hidden' => true,
        ]);
    }

    public function test_admin_can_edit_and_update_problem(): void
    {
        $problem = Problem::create([
            'title' => 'Old Problem', 'slug' => 'old-problem', 'difficulty' => 'easy',
            'description' => 'D', 'constraints' => 'C', 'input_format' => 'I', 'output_format' => 'O', 'time_limit' => 1000, 'memory_limit' => 256
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.problems.update', $problem->id), [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'difficulty' => 'medium',
            'time_limit' => 1500,
            'memory_limit' => 128,
            'test_cases' => [
                [
                    'input' => 'new_in',
                    'expected_output' => 'new_out',
                    'is_hidden' => 1
                ]
            ]
        ]);

        $response->assertRedirect(route('admin.problems.index'));
        $this->assertDatabaseHas('problems', [
            'id' => $problem->id,
            'title' => 'Updated Title',
            'difficulty' => 'medium',
        ]);

        $problem->refresh();
        $this->assertEquals(1, $problem->testCases()->count());
        $this->assertEquals('new_in', $problem->testCases->first()->input);
    }

    public function test_admin_can_delete_problem(): void
    {
        $problem = Problem::create([
            'title' => 'Problem to Delete', 'slug' => 'to-delete', 'difficulty' => 'easy',
            'description' => 'D', 'constraints' => 'C', 'input_format' => 'I', 'output_format' => 'O', 'time_limit' => 1000, 'memory_limit' => 256
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.problems.destroy', $problem->id));

        $response->assertRedirect(route('admin.problems.index'));
        $this->assertDatabaseMissing('problems', ['id' => $problem->id]);
    }

    public function test_admin_can_create_contest(): void
    {
        $problem = Problem::create([
            'title' => 'Contest Prob', 'slug' => 'contest-prob', 'difficulty' => 'easy',
            'description' => 'D', 'constraints' => 'C', 'input_format' => 'I', 'output_format' => 'O', 'time_limit' => 1000, 'memory_limit' => 256
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.contests.store'), [
            'title' => 'Sprint Challenge',
            'description' => 'Contest desc',
            'start_time' => now()->addHour()->toDateTimeString(),
            'end_time' => now()->addHours(3)->toDateTimeString(),
            'problems' => [$problem->id],
            'points' => [
                $problem->id => 150
            ]
        ]);

        $response->assertRedirect(route('admin.contests.index'));
        $this->assertDatabaseHas('contests', [
            'title' => 'Sprint Challenge',
        ]);

        $contest = Contest::where('title', 'Sprint Challenge')->first();
        $this->assertNotNull($contest);
        $this->assertEquals(1, $contest->problems()->count());
        $this->assertEquals(150, $contest->problems->first()->pivot->points);
    }

    public function test_admin_can_edit_and_update_contest(): void
    {
        $contest = Contest::create([
            'title' => 'Sprint Challenge',
            'slug' => 'sprint-challenge',
            'description' => 'Contest desc',
            'start_time' => now()->addHour(),
            'end_time' => now()->addHours(3),
        ]);

        $problem = Problem::create([
            'title' => 'Contest Prob', 'slug' => 'contest-prob', 'difficulty' => 'easy',
            'description' => 'D', 'constraints' => 'C', 'input_format' => 'I', 'output_format' => 'O', 'time_limit' => 1000, 'memory_limit' => 256
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.contests.update', $contest->id), [
            'title' => 'Sprint Challenge Updated',
            'description' => 'New description',
            'start_time' => now()->addHours(2)->toDateTimeString(),
            'end_time' => now()->addHours(5)->toDateTimeString(),
            'problems' => [$problem->id],
            'points' => [
                $problem->id => 250
            ]
        ]);

        $response->assertRedirect(route('admin.contests.index'));
        $this->assertDatabaseHas('contests', [
            'id' => $contest->id,
            'title' => 'Sprint Challenge Updated',
        ]);

        $contest->refresh();
        $this->assertEquals(1, $contest->problems()->count());
        $this->assertEquals(250, $contest->problems->first()->pivot->points);
    }

    public function test_admin_can_delete_contest(): void
    {
        $contest = Contest::create([
            'title' => 'Sprint Challenge',
            'slug' => 'sprint-challenge',
            'description' => 'Contest desc',
            'start_time' => now()->addHour(),
            'end_time' => now()->addHours(3),
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.contests.destroy', $contest->id));

        $response->assertRedirect(route('admin.contests.index'));
        $this->assertDatabaseMissing('contests', ['id' => $contest->id]);
    }
}
