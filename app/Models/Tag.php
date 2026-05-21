<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['name', 'slug'])]
class Tag extends Model
{
    use HasFactory;

    /**
     * Relationship with problems.
     */
    public function problems(): BelongsToMany
    {
        return $this->belongsToMany(Problem::class, 'problem_tag');
    }
}
