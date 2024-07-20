<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Issue; 
use App\Models\AnonIssue;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $issues = Issue::query();
        $anonIssues = AnonIssue::query();

        if ($search) {
            $issues->where('title', 'LIKE', "%{$search}%");
            $anonIssues->where('title', 'LIKE', "%{$search}%");

            $anonIssuesResult = $anonIssues->get();

            // If no title match found, search by code ignoring visibility
            if ($anonIssuesResult->isEmpty()) {
                $anonIssues = AnonIssue::where('code', $search)->get();
            } else {
                $anonIssues = $anonIssues->where('visibility', true)->get();
            }

            $issues = $issues->get();
        } else {
            $issues = $issues->get();
            $anonIssues = $anonIssues->where('visibility', true)->get();
        }

        return view('issues.index', compact('issues', 'anonIssues'));
    }
}
