<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Problem;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a comment or reply.
     */
    public function store(Request $request, Problem $problem)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $problem->comments()->create([
            'user_id' => auth()->id(),
            'parent_id' => $validated['parent_id'] ?? null,
            'body' => $validated['body'],
        ]);

        return back()->with('success', 'Comment posted successfully.');
    }

    /**
     * Toggle upvote for a comment.
     */
    public function upvote(Comment $comment)
    {
        $userId = auth()->id();
        
        if ($comment->upvotes()->where('user_id', $userId)->exists()) {
            $comment->upvotes()->detach($userId);
            $status = 'detached';
        } else {
            $comment->upvotes()->attach($userId);
            $status = 'attached';
        }

        if (request()->expectsJson() || request()->ajax()) {
            return response()->json([
                'status' => 'success',
                'action' => $status,
                'count' => $comment->upvotes()->count()
            ]);
        }

        return back();
    }

    /**
     * Delete a comment.
     */
    public function destroy(Comment $comment)
    {
        // Only author or admin can delete
        if ($comment->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $comment->delete();
        return back()->with('success', 'Comment deleted successfully.');
    }
}
