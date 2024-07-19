<?php

namespace App\Http\Controllers;

use App\Models\AnonIssue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\AnonIssueRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AnonIssueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $anonIssues = AnonIssue::paginate();

        return view('anon-issue.index', compact('anonIssues'))
            ->with('i', ($request->input('page', 1) - 1) * $anonIssues->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $anonIssue = new AnonIssue();

        return view('anon-issue.create', compact('anonIssue'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AnonIssueRequest $request): RedirectResponse
    {
        AnonIssue::create($request->validated());

        return Redirect::route('anon-issues.index')
            ->with('success', 'AnonIssue created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $anonIssue = AnonIssue::find($id);

        return view('anon-issue.show', compact('anonIssue'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $anonIssue = AnonIssue::find($id);

        return view('anon-issue.edit', compact('anonIssue'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AnonIssueRequest $request, AnonIssue $anonIssue): RedirectResponse
    {
        $anonIssue->update($request->validated());

        return Redirect::route('anon-issues.index')
            ->with('success', 'AnonIssue updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        AnonIssue::find($id)->delete();

        return Redirect::route('anon-issues.index')
            ->with('success', 'AnonIssue deleted successfully');
    }
}
