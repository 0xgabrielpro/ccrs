<?php

namespace App\Http\Controllers;

use App\Models\AnonIssue;
use Illuminate\Http\Request;

class AnonIssueController extends Controller
{
    public function index()
    {
        $anonIssues = AnonIssue::all();
        return view('anon-issues.index', compact('anonIssues'));
    }

    public function create()
    {
        return view('anon-issues.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'country' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'ward' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'file_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,txt|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('files', 'public');
        }

        AnonIssue::create([
            'title' => $request->title,
            'description' => $request->description,
            'country' => $request->country,
            'region' => $request->region,
            'ward' => $request->ward,
            'street' => $request->street,
            'file_path' => $filePath,
            'code' => uniqid(),
            'visibility' => true, // Default visibility
        ]);

        return redirect()->route('anon-issues.index')->with('success', 'Issue created successfully.');
    }

    public function edit(AnonIssue $anonIssue)
    {
        return view('anon-issues.edit', compact('anonIssue'));
    }

    public function update(Request $request, AnonIssue $anonIssue)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'country' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'ward' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'file_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,txt|max:2048',
        ]);

        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('files', 'public');
            
            if ($anonIssue->file_path) {
                Storage::disk('public')->delete($anonIssue->file_path);
            }
            $anonIssue->file_path = $filePath;
        }

        $anonIssue->title = $request->title;
        $anonIssue->description = $request->description;
        $anonIssue->country = $request->country;
        $anonIssue->region = $request->region;
        $anonIssue->ward = $request->ward;
        $anonIssue->street = $request->street;
        $anonIssue->save();

        return redirect()->route('anon-issues.index')->with('success', 'Issue updated successfully.');
    }

    public function destroy(AnonIssue $anonIssue)
    {

        if ($anonIssue->file_path) {
            Storage::disk('public')->delete($anonIssue->file_path);
        }
        
        $anonIssue->delete();

        return redirect()->route('anon-issues.index')->with('success', 'Issue deleted successfully.');
    }
}
