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
    public function store(AnonIssueRequest $request)
    {
        $anonIssue = AnonIssue::create($request->validated());

        $filePath = null;
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('files', $fileName, 'public');

            $anonIssue->file_path = $filePath;
            $anonIssue->update();
        }
    
        return redirect()->route('anon-issues.show', $anonIssue->id)
                         ->with('success', 'Issue created successfully.');
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
        if ($request->hasFile('file_path')) {

            if ($anonIssue->file_path) {
                Storage::disk('public')->delete($anonIssue->file_path);
            }
    
            $file = $request->file('file_path');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('files', $fileName, 'public');
    
            $anonIssue->file_path = $filePath;
        }
    
        $anonIssue->update($request->validated());
    
        return Redirect::route('anon-issues.index')
            ->with('success', 'AnonIssue updated successfully');
    }
    

    public function destroy($id): RedirectResponse
{
    $anonIssue = AnonIssue::find($id);

    if ($anonIssue->file_path) {
        Storage::disk('public')->delete($anonIssue->file_path);
    }

    $anonIssue->delete();

    return Redirect::route('anon-issues.index')
        ->with('success', 'AnonIssue deleted successfully');
}

}