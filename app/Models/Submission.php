<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'problem_id', 'contest_id', 'language', 'code', 'status', 'execution_time', 'memory_used'])]
class Submission extends Model
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
     * Relationship with contest.
     */
    public function contest(): BelongsTo
    {
        return $this->belongsTo(Contest::class);
    }
}
