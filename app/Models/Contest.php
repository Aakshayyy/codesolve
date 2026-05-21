<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['title', 'slug', 'description', 'start_time', 'end_time'])]
class Contest extends Model
{
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
        ];
    }

    /**
     * Relationship with problems.
     */
    public function problems(): BelongsToMany
    {
        return $this->belongsToMany(Problem::class, 'contest_problem')->withPivot('points');
    }

    /**
     * Relationship with submissions.
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }

    /**
     * Check if the contest has started.
     */
    public function hasStarted(): bool
    {
        return Carbon::now()->greaterThanOrEqualTo($this->start_time);
    }

    /**
     * Check if the contest has ended.
     */
    public function hasEnded(): bool
    {
        return Carbon::now()->greaterThan($this->end_time);
    }

    /**
     * Check if the contest is currently running.
     */
    public function isActive(): bool
    {
        return $this->hasStarted() && !$this->hasEnded();
    }

    /**
     * Check if the contest is upcoming.
     */
    public function isUpcoming(): bool
    {
        return Carbon::now()->lessThan($this->start_time);
    }

    /**
     * Get the remaining time in seconds.
     */
    public function getSecondsRemainingAttribute(): int
    {
        if ($this->isUpcoming()) {
            return Carbon::now()->diffInSeconds($this->start_time);
        }
        if ($this->isActive()) {
            return Carbon::now()->diffInSeconds($this->end_time);
        }
        return 0;
    }
}
