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

        // 7. Certificates processing
        $earnedCertificates = [];
        if ($solvedCount >= 1) {
            $earnedCertificates[] = [
                'type' => 'bronze',
                'name' => 'Bronze Certificate',
                'title' => 'Bronze Certificate of Coding Completion',
                'description' => 'Successfully solved at least 1 competitive coding problem.'
            ];
        }
        if ($solvedCount >= 5) {
            $earnedCertificates[] = [
                'type' => 'silver',
                'name' => 'Silver Certificate',
                'title' => 'Silver Certificate of Algorithmic Practice',
                'description' => 'Successfully solved at least 5 competitive coding problems.'
            ];
        }
        if ($solvedCount >= 10) {
            $earnedCertificates[] = [
                'type' => 'gold',
                'name' => 'Gold Certificate',
                'title' => 'Gold Certificate of Competitive Programming',
                'description' => 'Successfully solved at least 10 competitive coding problems.'
            ];
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
            'badges',
            'earnedCertificates'
        ));
    }

    /**
     * View a public certificate page.
     */
    public function viewCertificate(\App\Models\User $user, string $type)
    {
        // Calculate user's solved count
        $solvedCount = Submission::where('user_id', $user->id)
            ->where('status', 'Accepted')
            ->distinct('problem_id')
            ->count('problem_id');

        // Check if user qualifies for the certificate
        $qualifies = false;
        $title = '';
        $color = '';
        $description = '';
        
        switch ($type) {
            case 'bronze':
                $qualifies = $solvedCount >= 1;
                $title = 'Bronze Certificate of Coding Completion';
                $color = 'text-amber-600 border-amber-500 bg-amber-500';
                $description = 'Awarded to programmers who have taken their first steps into competitive coding by successfully solving algorithmic problems.';
                break;
            case 'silver':
                $qualifies = $solvedCount >= 5;
                $title = 'Silver Certificate of Algorithmic Practice';
                $color = 'text-slate-400 border-slate-300 bg-slate-400';
                $description = 'Awarded to programmers who have demonstrated persistent practice and solved a range of diverse programming problems.';
                break;
            case 'gold':
                $qualifies = $solvedCount >= 10;
                $title = 'Gold Certificate of Competitive Programming';
                $color = 'text-yellow-500 border-yellow-400 bg-yellow-500';
                $description = 'Awarded to advanced developers who have solved a comprehensive collection of challenging algorithm problems on CodeSolve.';
                break;
        }

        if (!$qualifies) {
            abort(403, 'User does not qualify for this certificate yet.');
        }

        $date = $user->created_at->format('F d, Y');

        return view('certificates.show', compact('user', 'title', 'type', 'description', 'date', 'solvedCount', 'color'));
    }
}
