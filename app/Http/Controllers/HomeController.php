<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Models\Issue; // Make sure to import the Issue model if not already imported

class HomeController extends Controller
{
    public function index()
    {
        // Fetch only the visible issues
        $issues = Issue::where('visibility', 1)->get();

        // Return the view with the issues data
        return view('home', compact('issues'));
    }
}
