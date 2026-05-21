<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\Problem;
use App\Models\Submission;
use App\Models\Tag;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Show the user dashboard with stats, streaks, charts and badges.
     */
    public function index()
    {
        $user = auth()->user();

        // 1. Problems solved count (unique problems where status is 'Accepted')
        $solvedProblems = Submission::where('user_id', $user->id)
            ->where('status', 'Accepted')
            ->distinct('problem_id')
            ->pluck('problem_id')
            ->toArray();

        $solvedCount = count($solvedProblems);

        // 2. Submission history (paginated list of user's submissions)
        $submissions = Submission::where('user_id', $user->id)
            ->with('problem')
            ->latest()
            ->paginate(10);

        // 3. Difficulty stats (for charts)
        $totalEasy = Problem::where('difficulty', 'easy')->count();
        $totalMedium = Problem::where('difficulty', 'medium')->count();
        $totalHard = Problem::where('difficulty', 'hard')->count();

        $solvedEasy = Problem::whereIn('id', $solvedProblems)->where('difficulty', 'easy')->count();
        $solvedMedium = Problem::whereIn('id', $solvedProblems)->where('difficulty', 'medium')->count();
        $solvedHard = Problem::whereIn('id', $solvedProblems)->where('difficulty', 'hard')->count();

        // 4. Tag progress (count solved problems by tag)
        $tags = Tag::withCount(['problems' => function($q) use ($solvedProblems) {
            $q->whereIn('problems.id', $solvedProblems);
        }])->get();

        $tagProgress = [];
        foreach ($tags as $tag) {
            if ($tag->problems_count > 0) {
                $tagProgress[] = [
                    'name' => $tag->name,
                    'count' => $tag->problems_count
                ];
            }
        }

        // 5. Achievement badges
        $allBadges = Badge::all();
        $unlockedBadgeIds = $user->badges()->pluck('badges.id')->toArray();

        $badges = [];
        foreach ($allBadges as $badge) {
            $badges[] = [
                'id' => $badge->id,
                'name' => $badge->name,
                'description' => $badge->description,
                'icon' => $badge->icon,
                'unlocked' => in_array($badge->id, $unlockedBadgeIds),
            ];
        }

        // 6. Streak validation (Check if streak is still active or needs resetting due to inactivity)
        $today = now()->startOfDay();
        $lastSubmission = $user->last_submission_at ? Carbon::parse($user->last_submission_at)->startOfDay() : null;
        
        if ($lastSubmission && $lastSubmission->lt($today->clone()->subDay())) {
            // Inactive for more than a day, reset streak to 0 in database
            $user->streak = 0;
            $user->save();
        }

        return view('dashboard', compact(
            'user',
            'solvedCount',
            'submissions',
            'totalEasy',
            'totalMedium',
            'totalHard',
            'solvedEasy',
            'solvedMedium',
            'solvedHard',
            'tagProgress',
            'badges'
        ));
    }
}
