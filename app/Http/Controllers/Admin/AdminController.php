<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Problem;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the Admin Dashboard with stats and analytics.
     */
    public function index()
    {
        $totalUsers = User::count();
        $totalProblems = Problem::count();
        $totalSubmissions = Submission::count();
        
        $acceptedCount = Submission::where('status', 'Accepted')->count();
        $successRate = $totalSubmissions > 0 ? round(($acceptedCount / $totalSubmissions) * 100, 1) : 0;

        $recentSubmissions = Submission::with(['user', 'problem'])
            ->latest()
            ->take(10)
            ->get();

        // Level distribution of problems
        $easyCount = Problem::where('difficulty', 'easy')->count();
        $mediumCount = Problem::where('difficulty', 'medium')->count();
        $hardCount = Problem::where('difficulty', 'hard')->count();

        return view('admin.index', compact(
            'totalUsers',
            'totalProblems',
            'totalSubmissions',
            'successRate',
            'recentSubmissions',
            'easyCount',
            'mediumCount',
            'hardCount'
        ));
    }

    /**
     * List all users.
     */
    public function users()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Toggle a user's role between 'admin' and 'user'.
     */
    public function toggleRole(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own role.');
        }

        $user->role = $user->role === 'admin' ? 'user' : 'admin';
        $user->save();

        return back()->with('success', "User '{$user->name}' role updated successfully.");
    }

    /**
     * Delete a user.
     */
    public function destroyUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself.');
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    /**
     * View all submissions in the system.
     */
    public function submissions(Request $request)
    {
        $query = Submission::with(['user', 'problem'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('language')) {
            $query->where('language', $request->language);
        }

        $submissions = $query->paginate(20);
        return view('admin.submissions', compact('submissions'));
    }
}
