<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['name', 'description', 'icon', 'requirement_type', 'requirement_value'])]
class Badge extends Model
{
    use HasFactory;

    /**
     * Relationship with users.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_badge');
    }
}
