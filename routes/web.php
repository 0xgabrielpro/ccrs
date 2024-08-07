<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\IssueChatController;
use App\Http\Controllers\EvidenceController;
use App\Http\Controllers\AnonIssueController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\LocationController;


Route::get('/welcome', function (){
    return view('welcome');
});

Route::get('/', [IssueController::class, 'index'])->name('home');

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/', [HomeController::class, 'index'])->name('home');
// });


Route::group(['middleware' => 'admin'], function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::prefix('admin/users')->name('admin.users.')->group(function () {
        Route::get('/create', [AdminUserController::class, 'create'])->name('create');
        Route::post('/', [AdminUserController::class, 'store'])->name('store');
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::get('/{user}', [AdminUserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [AdminUserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [AdminUserController::class, 'update'])->name('update');
        Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('destroy');
    });
});


Route::middleware(['auth:sanctum', 'verified'])->get('/myissues', function () {
    return view('myissues');
})->name('myissues');

Route::resource('issues', IssueController::class);
Route::post('issues/{issue}/reopen', [IssueController::class, 'reopen'])->name('issues.reopen');
Route::post('issues/{issue}/rate', [IssueController::class, 'rate'])->name('issues.rate');
Route::post('issues/{issue}/forward', [IssueController::class, 'forward'])->name('issues.forward');
Route::get('evidence/download/{file}', [EvidenceController::class, 'download'])->name('evidence.download');
Route::put('/issues/{issue}/update_status', [IssueController::class, 'updateStatus'])->name('issues.update_status');
Route::put('/issues/{id}/update_visibility', [IssueController::class, 'updateVisibility'])->name('issues.update_visibility');

Route::get('/issues/search', [IssueController::class, 'search'])->name('issues.search');

Route::resource('anon-issues', AnonIssueController::class);
Route::resource('issue_chats', IssueChatController::class);
Route::middleware(['auth', 'role:leader'])->group(function () {
    Route::put('anon-issues/{anon_issue}/update-status', [AnonIssueController::class, 'updateStatus'])->name('anon-issues.update_status');
    Route::post('anon-issues/{anon_issue}/forward', [AnonIssueController::class, 'forward'])->name('anon-issues.forward');
    Route::put('anon-issues/{anon_issue}/update-visibility', [AnonIssueController::class, 'updateVisibility'])->name('anon-issues.update_visibility');
});

Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');

Route::middleware(['auth', 'role:leader'])->group(function () {
    Route::get('/leader/issues', [IssueController::class, 'leaderIssues'])->name('leader.issues');
    Route::get('/leader/myarea', [IssueController::class, 'myArea'])->name('leader.myarea');
    Route::get('/leader/insights', [IssueController::class, 'showInsights'])->name('leader.insights');
});

Route::get('/api2/countries', [LocationController::class, 'getCountries']);
Route::get('/api2/regions', [LocationController::class, 'getRegions']);
Route::get('/api2/districts', [LocationController::class, 'getDistricts']);
Route::get('/api2/wards', [LocationController::class, 'getWards']);
Route::get('/api2/streets', [LocationController::class, 'getStreets']);
