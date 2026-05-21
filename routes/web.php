<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProblemController;
use App\Http\Controllers\ContestController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminProblemController;
use App\Http\Controllers\Admin\AdminContestController;
use App\Http\Controllers\TheoryController;
use Illuminate\Support\Facades\Route;

// Public Welcome Page
Route::get('/', function () {
    return view('welcome');
});

// User Dashboard (auth required)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Public Leaderboard rankings
Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');

// Public Coding Problems list & details
Route::get('/problems', [ProblemController::class, 'index'])->name('problems.index');
Route::get('/problems/{problem:slug}', [ProblemController::class, 'show'])->name('problems.show');

// Public Contests hub
Route::get('/contests', [ContestController::class, 'index'])->name('contests.index');
Route::get('/contests/{contest:slug}', [ContestController::class, 'show'])->name('contests.show');
Route::get('/contests/{contest:slug}/leaderboard', [ContestController::class, 'leaderboard'])->name('contests.leaderboard');

// Public Theory Section
Route::get('/theory', [TheoryController::class, 'index'])->name('theory.index');
Route::get('/theory/{category}', [TheoryController::class, 'category'])->name('theory.category');
Route::get('/theory/{category}/{topic}', [TheoryController::class, 'topic'])->name('theory.topic');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Code compilation and evaluation
    Route::post('/problems/{problem:slug}/run', [ProblemController::class, 'run'])->name('problems.run');
    Route::post('/problems/{problem:slug}/submit', [ProblemController::class, 'submit'])->name('problems.submit');

    // Comment and Discussion actions
    Route::post('/problems/{problem:slug}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/comments/{comment}/upvote', [CommentController::class, 'upvote'])->name('comments.upvote');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Profile Settings
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Panel (auth and custom admin role middleware required)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    
    // User administration
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users/{user}/toggle-role', [AdminController::class, 'toggleRole'])->name('users.toggle-role');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    
    // Submission view
    Route::get('/submissions', [AdminController::class, 'submissions'])->name('submissions');
    
    // Problems & Contests CRUD
    Route::resource('problems', AdminProblemController::class);
    Route::resource('contests', AdminContestController::class);
});

require __DIR__.'/auth.php';
