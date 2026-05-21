<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['title', 'slug', 'description', 'difficulty', 'constraints', 'input_format', 'output_format', 'time_limit', 'memory_limit'])]
class Problem extends Model
{
    use HasFactory;

    /**
     * Relationship with tags.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'problem_tag');
    }

    /**
     * Relationship with test cases.
     */
    public function testCases(): HasMany
    {
        return $this->hasMany(TestCase::class);
    }

    /**
     * Relationship with submissions.
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }

    /**
     * Relationship with comments (discussion).
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id')->latest();
    }

    /**
     * Relationship with contests.
     */
    public function contests(): BelongsToMany
    {
        return $this->belongsToMany(Contest::class, 'contest_problem');
    }
}
