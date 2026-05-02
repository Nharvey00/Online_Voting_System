<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\VoterController;
use App\Http\Controllers\CandidateApplicationController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ElectionController;
use App\Http\Controllers\Admin\PositionController;
use App\Http\Controllers\Admin\CandidateController;
use App\Http\Controllers\Admin\ResultsController;
use App\Http\Controllers\Admin\VoterController as AdminVoterController;
use Illuminate\Support\Facades\Route;

// ─── Landing Page ─────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ─── Auth pages — no middleware, anyone can view ──────────
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');

// ─── Auth form submissions — no middleware ────────────────
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// ─── Authenticated voter/candidate routes ─────────────────
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Voter dashboard
    Route::get('/voter/dashboard', [VoterController::class, 'dashboard'])->name('voter.dashboard');

    // View candidates list
    Route::get('/candidates', [VoterController::class, 'candidates'])->name('voter.candidates');

    // Candidate application
    Route::get('/apply', [CandidateApplicationController::class, 'create'])->name('candidate.apply');
    Route::post('/apply', [CandidateApplicationController::class, 'store'])->name('candidate.apply.store');
    Route::get('/application/status', [CandidateApplicationController::class, 'status'])->name('candidate.status');

    // Voting
    Route::get('/vote', [VoteController::class, 'index'])->name('vote.index');
    Route::post('/vote', [VoteController::class, 'store'])->name('vote.store');
    Route::get('/vote/receipt', [VoteController::class, 'receipt'])->name('vote.receipt');

    // Results
    Route::get('/results', [VoteController::class, 'results'])->name('vote.results');
});

// ─── Admin login page — anyone can view ───────────────────
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);

// ─── Admin authenticated routes ───────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Elections
    Route::get('/elections', [ElectionController::class, 'index'])->name('elections.index');
    Route::get('/elections/create', [ElectionController::class, 'create'])->name('elections.create');
    Route::post('/elections', [ElectionController::class, 'store'])->name('elections.store');
    Route::get('/elections/{election}/edit', [ElectionController::class, 'edit'])->name('elections.edit');
    Route::put('/elections/{election}', [ElectionController::class, 'update'])->name('elections.update');
    Route::patch('/elections/{election}/status', [ElectionController::class, 'updateStatus'])->name('elections.updateStatus');
    Route::patch('/elections/{election}/publish', [ElectionController::class, 'publishResults'])->name('elections.publish');

    // Positions (nested under elections)
    Route::get('/elections/{election}/positions', [PositionController::class, 'index'])->name('positions.index');
    Route::get('/elections/{election}/positions/create', [PositionController::class, 'create'])->name('positions.create');
    Route::post('/elections/{election}/positions', [PositionController::class, 'store'])->name('positions.store');
    Route::get('/elections/{election}/positions/{position}/edit', [PositionController::class, 'edit'])->name('positions.edit');
    Route::put('/elections/{election}/positions/{position}', [PositionController::class, 'update'])->name('positions.update');
    Route::delete('/elections/{election}/positions/{position}', [PositionController::class, 'destroy'])->name('positions.destroy');

    // Candidate applications
    Route::get('/candidates', [CandidateController::class, 'index'])->name('candidates.index');
    Route::get('/candidates/{candidate}', [CandidateController::class, 'show'])->name('candidates.show');
    Route::patch('/candidates/{candidate}/approve', [CandidateController::class, 'approve'])->name('candidates.approve');
    Route::patch('/candidates/{candidate}/reject', [CandidateController::class, 'reject'])->name('candidates.reject');

    // Results
    Route::get('/results', [ResultsController::class, 'index'])->name('results.index');

    // Manage Voters
    Route::get('/voters', [AdminVoterController::class, 'index'])->name('voters.index');
    Route::get('/voters/{user}', [AdminVoterController::class, 'show'])->name('voters.show');
});