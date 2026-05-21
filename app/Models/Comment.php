<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'problem_id', 'parent_id', 'body'])]
class Comment extends Model
{
    use HasFactory;

    /**
     * Relationship with user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with problem.
     */
    public function problem(): BelongsTo
    {
        return $this->belongsTo(Problem::class);
    }

    /**
     * Relationship with parent comment (for replies).
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Relationship with replies.
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id')->oldest();
    }

    /**
     * Relationship with upvotes.
     */
    public function upvotes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'comment_upvotes');
    }
}
