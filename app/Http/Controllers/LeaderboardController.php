<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LeaderboardController extends Controller
{
    /**
     * Display the leaderboard rankings (Global and Weekly).
     */
    public function index(Request $request)
    {
        $type = $request->query('type', 'global');

        if ($type === 'weekly') {
            // Weekly Leaderboard: Based on submissions accepted in the last 7 days
            $sevenDaysAgo = Carbon::now()->subDays(7);

            $submissions = Submission::where('status', 'Accepted')
                ->where('created_at', '>=', $sevenDaysAgo)
                ->with(['user', 'problem'])
                ->get();

            // Group by user and calculate weekly points
            $weeklyScores = [];
            foreach ($submissions as $sub) {
                // Ensure user exists
                if (!$sub->user) continue;

                $userId = $sub->user_id;

                if (!isset($weeklyScores[$userId])) {
                    $weeklyScores[$userId] = [
                        'user' => $sub->user,
                        'points' => 0,
                        'solved_count' => 0,
                        'solved_problems' => [], // Avoid double counting if user submitted multiple times
                    ];
                }

                $probId = $sub->problem_id;
                if (!in_array($probId, $weeklyScores[$userId]['solved_problems'])) {
                    $weeklyScores[$userId]['solved_problems'][] = $probId;
                    
                    $difficulty = $sub->problem->difficulty;
                    $points = 10; // easy
                    if ($difficulty === 'medium') {
                        $points = 20;
                    } elseif ($difficulty === 'hard') {
                        $points = 30;
                    }

                    $weeklyScores[$userId]['points'] += $points;
                    $weeklyScores[$userId]['solved_count'] += 1;
                }
            }

            // Sort by points DESC, then by solved_count DESC
            usort($weeklyScores, function ($a, $b) {
                if ($a['points'] !== $b['points']) {
                    return $b['points'] <=> $a['points'];
                }
                return $b['solved_count'] <=> $a['solved_count'];
            });

            // Implement simple pagination in memory
            $page = max(1, (int)$request->query('page', 1));
            $perPage = 20;
            $offset = ($page - 1) * $perPage;
            
            $total = count($weeklyScores);
            $weeklyLeaderboard = array_slice($weeklyScores, $offset, $perPage);
            
            // Build a manual paginator array format
            $paginator = [
                'current_page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'last_page' => ceil($total / $perPage),
                'has_pages' => $total > $perPage,
            ];

            return view('leaderboard.index', compact('weeklyLeaderboard', 'type', 'paginator'));
        }

        // Global Leaderboard: Ordered by total points accumulated
        $globalLeaderboard = User::orderBy('points', 'desc')
            ->orderBy('id', 'asc')
            ->paginate(20)
            ->withQueryString();

        return view('leaderboard.index', compact('globalLeaderboard', 'type'));
    }
}
