<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Models\Issue; // Make sure to import the Issue model if not already imported

class HomeController extends Controller
{
    public function index()
    {
        // Fetch all issues from the database
        $issues = Issue::all();

        // Return the view with the issues data
        return view('home', compact('issues'));
    }
}
