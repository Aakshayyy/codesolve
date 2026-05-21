<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Problem;
use App\Models\Contest;
use App\Models\Tag;
use App\Models\Submission;
use App\Models\Badge;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class UserJourneyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test guest cannot access the dashboard and is redirected.
     */
    public function test_guest_is_redirected_from_dashboard(): void
    {
        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('login'));
    }

    /**
     * Test authenticated user can access the dashboard and see their stats/badges.
     */
    public function test_user_can_access_dashboard_with_stats_and_badges(): void
    {
        $user = User::factory()->create([
            'points' => 150,
            'streak' => 3,
            'last_submission_at' => now(),
        ]);

        $problem = Problem::create([
            'title' => 'Sum of Two', 'slug' => 'sum-of-two', 'difficulty' => 'easy',
            'description' => 'D', 'constraints' => 'C', 'input_format' => 'I', 'output_format' => 'O', 'time_limit' => 1000, 'memory_limit' => 256
        ]);

        $tag = Tag::create(['name' => 'Arrays', 'slug' => 'arrays']);
        $problem->tags()->attach($tag);

        // Accepted submission
        Submission::create([
            'user_id' => $user->id,
            'problem_id' => $problem->id,
            'status' => 'Accepted',
            'language' => 'python',
            'code' => 'print(1)',
            'execution_time' => 50,
            'memory_used' => 100,
        ]);

        // Unlocked Badge
        $badge = Badge::create([
            'name' => 'Streak Starter',
            'description' => 'Maintain a coding streak of 3 consecutive days.',
            'icon' => 'fire',
            'requirement_type' => 'streak',
            'requirement_value' => 3
        ]);
        $user->badges()->attach($badge);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
        $response->assertSee($user->name);
        $response->assertSee('150'); // Points
        $response->assertSee('3'); // Streak
        $response->assertSee('Streak Starter'); // Unlocked Badge
        $response->assertSee('Sum of Two'); // Solved submission history
    }

    /**
     * Test streak resets on dashboard view if user is inactive for > 1 day.
     */
    public function test_user_streak_resets_on_dashboard_due_to_inactivity(): void
    {
        $user = User::factory()->create([
            'streak' => 5,
            'last_submission_at' => now()->subDays(2),
        ]);

        $this->assertEquals(5, $user->streak);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
        $user->refresh();
        $this->assertEquals(0, $user->streak);
    }

    /**
     * Test listing of contests (active, upcoming, and past).
     */
    public function test_user_can_view_contests_list(): void
    {
        // Active
        $active = Contest::create([
            'title' => 'Active Contest',
            'slug' => 'active-contest',
            'description' => 'Desc',
            'start_time' => now()->subHour(),
            'end_time' => now()->addHour(),
        ]);

        // Upcoming
        $upcoming = Contest::create([
            'title' => 'Upcoming Contest',
            'slug' => 'upcoming-contest',
            'description' => 'Desc',
            'start_time' => now()->addDays(2),
            'end_time' => now()->addDays(2)->addHours(2),
        ]);

        // Past
        $past = Contest::create([
            'title' => 'Past Contest',
            'slug' => 'past-contest',
            'description' => 'Desc',
            'start_time' => now()->subDays(3),
            'end_time' => now()->subDays(3)->addHours(2),
        ]);

        $response = $this->get(route('contests.index'));

        $response->assertOk();
        $response->assertSee('Active Contest');
        $response->assertSee('Upcoming Contest');
        $response->assertSee('Past Contest');
    }

    /**
     * Test viewing upcoming contest displays upcoming view (countdown).
     */
    public function test_viewing_upcoming_contest_shows_upcoming_view(): void
    {
        $upcoming = Contest::create([
            'title' => 'Upcoming Championship',
            'slug' => 'upcoming-champ',
            'description' => 'This contest starts soon.',
            'start_time' => now()->addHours(5),
            'end_time' => now()->addHours(8),
        ]);

        $response = $this->get(route('contests.show', $upcoming));

        $response->assertOk();
        $response->assertSee('Upcoming Championship');
        $response->assertSee('Starts on');
    }

    /**
     * Test viewing active contest shows the contest page with problem list.
     */
    public function test_viewing_active_contest_shows_problems_list(): void
    {
        $active = Contest::create([
            'title' => 'Active Championship',
            'slug' => 'active-champ',
            'description' => 'This contest is live.',
            'start_time' => now()->subHour(),
            'end_time' => now()->addHours(2),
        ]);

        $problem = Problem::create([
            'title' => 'Contest Problem A', 'slug' => 'contest-prob-a', 'difficulty' => 'easy',
            'description' => 'D', 'constraints' => 'C', 'input_format' => 'I', 'output_format' => 'O', 'time_limit' => 1000, 'memory_limit' => 256
        ]);

        $active->problems()->attach($problem->id, ['points' => 100]);

        $response = $this->get(route('contests.show', $active));

        $response->assertOk();
        $response->assertSee('Active Championship');
        $response->assertSee('Contest Problem A');
    }

    /**
     * Test upcoming contest leaderboard redirects back with error.
     */
    public function test_upcoming_contest_leaderboard_redirects(): void
    {
        $upcoming = Contest::create([
            'title' => 'Upcoming Champ',
            'slug' => 'upcoming-champ',
            'description' => 'Soon.',
            'start_time' => now()->addHour(),
            'end_time' => now()->addHours(3),
        ]);

        $response = $this->get(route('contests.leaderboard', $upcoming));

        $response->assertRedirect(route('contests.show', $upcoming));
        $response->assertSessionHas('error', 'Contest has not started yet.');
    }

    /**
     * Test leaderboard ranking calculation for active/past contests.
     */
    public function test_contest_leaderboard_ranks_users_by_points_and_penalty(): void
    {
        // Setup contest
        $contest = Contest::create([
            'title' => 'Code Battle',
            'slug' => 'code-battle',
            'description' => 'Desc',
            'start_time' => now()->subHour(),
            'end_time' => now()->addHours(2),
        ]);

        $prob1 = Problem::create([
            'title' => 'Prob 1', 'slug' => 'prob-1', 'difficulty' => 'easy',
            'description' => 'D', 'constraints' => 'C', 'input_format' => 'I', 'output_format' => 'O', 'time_limit' => 1000, 'memory_limit' => 256
        ]);
        $prob2 = Problem::create([
            'title' => 'Prob 2', 'slug' => 'prob-2', 'difficulty' => 'medium',
            'description' => 'D', 'constraints' => 'C', 'input_format' => 'I', 'output_format' => 'O', 'time_limit' => 1000, 'memory_limit' => 256
        ]);

        $contest->problems()->attach([
            $prob1->id => ['points' => 100],
            $prob2->id => ['points' => 200]
        ]);

        // Users
        $user1 = User::factory()->create(['name' => 'User One']);
        $user2 = User::factory()->create(['name' => 'User Two']);

        // Submissions
        // User 1 gets Wrong Answer on Prob 1, then Accepted 10 mins in.
        $sub1 = new Submission([
            'user_id' => $user1->id,
            'problem_id' => $prob1->id,
            'contest_id' => $contest->id,
            'status' => 'Wrong Answer',
            'language' => 'python',
            'code' => 'code',
        ]);
        $sub1->created_at = now()->subHour()->addMinutes(5);
        $sub1->save();

        $sub2 = new Submission([
            'user_id' => $user1->id,
            'problem_id' => $prob1->id,
            'contest_id' => $contest->id,
            'status' => 'Accepted',
            'language' => 'python',
            'code' => 'code',
        ]);
        $sub2->created_at = now()->subHour()->addMinutes(10);
        $sub2->save();

        // User 2 solves Prob 1 15 mins in with no wrong attempts.
        $sub3 = new Submission([
            'user_id' => $user2->id,
            'problem_id' => $prob1->id,
            'contest_id' => $contest->id,
            'status' => 'Accepted',
            'language' => 'python',
            'code' => 'code',
        ]);
        $sub3->created_at = now()->subHour()->addMinutes(15);
        $sub3->save();

        // User 1 solves Prob 2 30 mins in with no wrong attempts.
        $sub4 = new Submission([
            'user_id' => $user1->id,
            'problem_id' => $prob2->id,
            'contest_id' => $contest->id,
            'status' => 'Accepted',
            'language' => 'python',
            'code' => 'code',
        ]);
        $sub4->created_at = now()->subHour()->addMinutes(30);
        $sub4->save();

        $response = $this->get(route('contests.leaderboard', $contest));
        $response->assertOk();

        // User 1 has:
        // - Prob 1: 10 mins taken + 1 wrong attempt (20 mins penalty) = 30 mins. Points = 100
        // - Prob 2: 30 mins taken. Points = 200
        // Total points = 300, total time = 60
        // User 2 has:
        // - Prob 1: 15 mins taken. Points = 100
        // Total points = 100, total time = 15

        // User 1 should be ranked #1 because they have 300 points vs User 2's 100 points.
        $response->assertSeeInOrder([
            'User One',
            '300',
            'User Two',
            '100'
        ]);
    }

    /**
     * Test global leaderboard index page.
     */
    public function test_viewing_global_leaderboard_ranks_users_by_total_points(): void
    {
        $user1 = User::factory()->create(['name' => 'Low Scorer', 'points' => 50]);
        $user2 = User::factory()->create(['name' => 'High Scorer', 'points' => 500]);

        $response = $this->get(route('leaderboard'));

        $response->assertOk();
        $response->assertSeeInOrder([
            'High Scorer',
            '500',
            'Low Scorer',
            '50'
        ]);
    }

    /**
     * Test weekly leaderboard index page.
     */
    public function test_viewing_weekly_leaderboard_ranks_users_by_weekly_submissions(): void
    {
        $user1 = User::factory()->create(['name' => 'Weekly Star']);
        $user2 = User::factory()->create(['name' => 'Weekly Runner']);

        $prob1 = Problem::create([
            'title' => 'Prob 1', 'slug' => 'prob-1', 'difficulty' => 'easy', // 10 points
            'description' => 'D', 'constraints' => 'C', 'input_format' => 'I', 'output_format' => 'O', 'time_limit' => 1000, 'memory_limit' => 256
        ]);
        $prob2 = Problem::create([
            'title' => 'Prob 2', 'slug' => 'prob-2', 'difficulty' => 'medium', // 20 points
            'description' => 'D', 'constraints' => 'C', 'input_format' => 'I', 'output_format' => 'O', 'time_limit' => 1000, 'memory_limit' => 256
        ]);

        // User 1 solves Prob 2 (20 pts)
        $wsub1 = new Submission([
            'user_id' => $user1->id,
            'problem_id' => $prob2->id,
            'status' => 'Accepted',
            'language' => 'python',
            'code' => 'code',
        ]);
        $wsub1->created_at = now()->subDays(2);
        $wsub1->save();

        // User 2 solves Prob 1 (10 pts)
        $wsub2 = new Submission([
            'user_id' => $user2->id,
            'problem_id' => $prob1->id,
            'status' => 'Accepted',
            'language' => 'python',
            'code' => 'code',
        ]);
        $wsub2->created_at = now()->subDays(3);
        $wsub2->save();

        // Old submission from 10 days ago (should not count for weekly)
        $wsub3 = new Submission([
            'user_id' => $user2->id,
            'problem_id' => $prob2->id,
            'status' => 'Accepted',
            'language' => 'python',
            'code' => 'code',
        ]);
        $wsub3->created_at = now()->subDays(10);
        $wsub3->save();

        $response = $this->get(route('leaderboard', ['type' => 'weekly']));

        $response->assertOk();
        $response->assertSeeInOrder([
            'Weekly Star',
            '20',
            'Weekly Runner',
            '10'
        ]);
    }
}
