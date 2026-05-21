<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Models\Submission;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ContestController extends Controller
{
    /**
     * Display listings of active, upcoming, and past contests.
     */
    public function index()
    {
        $now = Carbon::now();

        $activeContests = Contest::where('start_time', '<=', $now)
            ->where('end_time', '>=', $now)
            ->orderBy('end_time', 'asc')
            ->get();

        $upcomingContests = Contest::where('start_time', '>', $now)
            ->orderBy('start_time', 'asc')
            ->get();

        $pastContests = Contest::where('end_time', '<', $now)
            ->orderBy('end_time', 'desc')
            ->paginate(10);

        return view('contests.index', compact('activeContests', 'upcomingContests', 'pastContests'));
    }

    /**
     * Show a contest's details and problem list (if started).
     */
    public function show(Contest $contest)
    {
        if ($contest->isUpcoming()) {
            return view('contests.upcoming', compact('contest'));
        }

        $contest->load('problems');
        
        // Calculate solved problems in this contest for the authenticated user
        $solvedProblemIds = [];
        if (auth()->check()) {
            $solvedProblemIds = Submission::where('user_id', auth()->id())
                ->where('contest_id', $contest->id)
                ->where('status', 'Accepted')
                ->pluck('problem_id')
                ->toArray();
        }

        return view('contests.show', compact('contest', 'solvedProblemIds'));
    }

    /**
     * Display the real-time contest leaderboard.
     */
    public function leaderboard(Contest $contest)
    {
        if ($contest->isUpcoming()) {
            return redirect()->route('contests.show', $contest)->with('error', 'Contest has not started yet.');
        }

        // Fetch all submissions in this contest
        $submissions = Submission::where('contest_id', $contest->id)
            ->with(['user', 'problem'])
            ->orderBy('created_at', 'asc')
            ->get();

        $leaderboard = [];

        foreach ($submissions as $sub) {
            $userId = $sub->user_id;

            if (!isset($leaderboard[$userId])) {
                $leaderboard[$userId] = [
                    'user' => $sub->user,
                    'problems' => [], // tracking status for each problem
                    'total_points' => 0,
                    'total_time' => 0, // total time from contest start to accepted submissions
                    'solved_count' => 0,
                ];
            }

            $probId = $sub->problem_id;

            // If the user has already solved this problem, skip subsequent submissions
            if (isset($leaderboard[$userId]['problems'][$probId]['solved']) && $leaderboard[$userId]['problems'][$probId]['solved'] === true) {
                continue;
            }

            if (!isset($leaderboard[$userId]['problems'][$probId])) {
                $leaderboard[$userId]['problems'][$probId] = [
                    'attempts' => 0,
                    'solved' => false,
                    'points' => 0,
                    'time_taken' => 0
                ];
            }

            if ($sub->status === 'Accepted') {
                $leaderboard[$userId]['problems'][$probId]['solved'] = true;
                
                // Fetch points allocated to this problem in the contest
                $pivot = $contest->problems->where('id', $probId)->first()->pivot ?? null;
                $points = $pivot ? $pivot->points : 100;
                
                $leaderboard[$userId]['problems'][$probId]['points'] = $points;
                
                // Time taken is the difference in minutes between contest start and submission time
                $timeTaken = max(0, Carbon::parse($contest->start_time)->diffInMinutes($sub->created_at));
                $leaderboard[$userId]['problems'][$probId]['time_taken'] = $timeTaken;
                
                // Score = points, Penalty = time taken + 20 minutes for each previous wrong attempt
                $penalty = $timeTaken + ($leaderboard[$userId]['problems'][$probId]['attempts'] * 20);
                
                $leaderboard[$userId]['total_points'] += $points;
                $leaderboard[$userId]['total_time'] += $penalty;
                $leaderboard[$userId]['solved_count'] += 1;
            } else {
                $leaderboard[$userId]['problems'][$probId]['attempts'] += 1;
            }
        }

        // Sort the leaderboard: Points DESC, Penalty Time ASC
        usort($leaderboard, function ($a, $b) {
            if ($a['total_points'] !== $b['total_points']) {
                return $b['total_points'] <=> $a['total_points'];
            }
            return $a['total_time'] <=> $b['total_time'];
        });

        return view('contests.leaderboard', compact('contest', 'leaderboard'));
    }
}
