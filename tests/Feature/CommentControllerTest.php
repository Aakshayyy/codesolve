<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Problem;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Problem $problem;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->problem = Problem::create([
            'title' => 'Sample Prob', 'slug' => 'sample-prob', 'difficulty' => 'easy',
            'description' => 'D', 'constraints' => 'C', 'input_format' => 'I', 'output_format' => 'O', 'time_limit' => 1000, 'memory_limit' => 256
        ]);
    }

    public function test_guest_cannot_post_comment(): void
    {
        $response = $this->post(route('comments.store', $this->problem->slug), [
            'body' => 'Nice problem!',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseEmpty('comments');
    }

    public function test_user_can_post_comment(): void
    {
        $response = $this->actingAs($this->user)->post(route('comments.store', $this->problem->slug), [
            'body' => 'Excellent problem formulation!',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('comments', [
            'user_id' => $this->user->id,
            'problem_id' => $this->problem->id,
            'body' => 'Excellent problem formulation!',
            'parent_id' => null,
        ]);
    }

    public function test_user_can_post_nested_reply(): void
    {
        $comment = Comment::create([
            'user_id' => $this->user->id,
            'problem_id' => $this->problem->id,
            'body' => 'Root comment',
        ]);

        $replyUser = User::factory()->create();

        $response = $this->actingAs($replyUser)->post(route('comments.store', $this->problem->slug), [
            'body' => 'This is a reply to the root comment',
            'parent_id' => $comment->id,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('comments', [
            'user_id' => $replyUser->id,
            'problem_id' => $this->problem->id,
            'body' => 'This is a reply to the root comment',
            'parent_id' => $comment->id,
        ]);
    }

    public function test_user_can_upvote_comment_once_and_remove_on_second_upvote(): void
    {
        $comment = Comment::create([
            'user_id' => $this->user->id,
            'problem_id' => $this->problem->id,
            'body' => 'Upvotable comment',
        ]);

        // First upvote
        $response = $this->actingAs($this->user)->postJson(route('comments.upvote', $comment->id));
        $response->assertOk();
        $response->assertJson([
            'status' => 'success',
            'action' => 'attached',
            'count' => 1
        ]);
        $this->assertEquals(1, $comment->upvotes()->count());

        // Second upvote (should toggle off)
        $response = $this->actingAs($this->user)->postJson(route('comments.upvote', $comment->id));
        $response->assertOk();
        $response->assertJson([
            'status' => 'success',
            'action' => 'detached',
            'count' => 0
        ]);
        $this->assertEquals(0, $comment->upvotes()->count());
    }

    public function test_author_can_delete_their_comment(): void
    {
        $comment = Comment::create([
            'user_id' => $this->user->id,
            'problem_id' => $this->problem->id,
            'body' => 'Deletable comment',
        ]);

        $response = $this->actingAs($this->user)->delete(route('comments.destroy', $comment->id));

        $response->assertRedirect();
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    public function test_non_author_cannot_delete_comment(): void
    {
        $comment = Comment::create([
            'user_id' => $this->user->id,
            'problem_id' => $this->problem->id,
            'body' => 'Non-deletable comment',
        ]);

        $otherUser = User::factory()->create();

        $response = $this->actingAs($otherUser)->delete(route('comments.destroy', $comment->id));

        $response->assertStatus(403);
        $this->assertDatabaseHas('comments', ['id' => $comment->id]);
    }

    public function test_admin_can_delete_any_comment(): void
    {
        $comment = Comment::create([
            'user_id' => $this->user->id,
            'problem_id' => $this->problem->id,
            'body' => 'Admin deletable comment',
        ]);

        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->delete(route('comments.destroy', $comment->id));

        $response->assertRedirect();
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }
}
