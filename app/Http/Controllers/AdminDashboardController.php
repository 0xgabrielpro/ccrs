<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Your logic to display the admin dashboard goes here
        return view('admin.dashboard');
    }
}
