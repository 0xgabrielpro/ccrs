<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class LeaderboardController extends Controller
{
    /**
     * Display the leaderboard.
     */
    public function index(): View
    {
        // Fetch leaders with the count of issues they have resolved
        $leaders = User::where('role', 'leader')
            ->withCount('issues')
            ->orderBy('issues_count', 'desc')
            ->get();

        return view('leaderboard.index', compact('leaders'));
    }
}
