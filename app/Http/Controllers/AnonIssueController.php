<?php

namespace App\Http\Controllers;

use App\Models\AnonIssue;
use App\Models\Category;
use App\Models\Country;
use App\Models\Leader;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\AnonIssueRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Helpers\UserHelper;


class AnonIssueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $anonIssues = AnonIssue::where('visibility', 1)->paginate();

        return view('anon-issue.index', compact('anonIssues'))
            ->with('i', ($request->input('page', 1) - 1) * $anonIssues->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $anonIssue = new AnonIssue();
        $categories = Category::all();
        return view('anon-issue.create', compact('anonIssue', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'string',
            'country_id' => 'required|integer',
            'region_id' => 'required|integer',
            'district_id' => 'required|integer',
            'ward_id' => 'required|integer',
            'street_id' => 'required|integer',
            'category_id' => 'required|integer',
            'file_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,xls,xlsx',
        ]);

        $filePath = null;
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('files', $fileName, 'public');
            $validated['file_path'] = $filePath;
        }

        $anonIssue = new AnonIssue($validated);
        $anonIssue->visibility = false;
        $anonIssue->read = false;
        $anonIssue->to_user_id = UserHelper::findMatchingByUserLocation($anonIssue->country_id, $anonIssue->region_id, $anonIssue->district_id, $anonIssue->ward_id, $anonIssue->street_id, 'leader', 1, $request->category_id);
        $anonIssue->sealed_by = null; 
        $anonIssue->citizen_satisfied = false;
        $anonIssue->code = Str::random(10);
        $anonIssue->save();

        $issueCode = $anonIssue->code;
        session()->flash('issue_code', $issueCode);
        session()->flash('issue_url', route('anon-issues.show', $anonIssue->id));

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $anonIssue = AnonIssue::find($id);
        $leaders = Leader::all();
        return view('anon-issue.show', compact('anonIssue', 'leaders'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $anonIssue = AnonIssue::find($id);
        $categories = Category::all();
        return view('anon-issue.edit', compact('anonIssue', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AnonIssue $anonIssue)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string',
            'country_id' => 'nullable|integer',
            'region_id' => 'nullable|integer',
            'district_id' => 'nullable|integer',
            'ward_id' => 'nullable|integer',
            'street_id' => 'nullable|integer',
            'category_id' => 'nullable|integer',
            'file_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,xls,xlsx',
        ]);

        $filteredData = array_filter($validated, function ($value) {
            return !is_null($value) && $value !== '';
        });

        if ($request->hasFile('file_path')) {
            $filteredData['file_path'] = $request->file('file_path')->store('files');
        }

        $anonIssue->update($filteredData);

        if (isset($filteredData['country_id']) || isset($filteredData['region_id']) || isset($filteredData['district_id']) || isset($filteredData['ward_id']) || isset($filteredData['street_id']) || isset($filteredData['category_id'])) {
            $anonIssue->to_user_id = UserHelper::findMatchingByUserLocation(
                $anonIssue->country_id, 
                $anonIssue->region_id, 
                $anonIssue->district_id, 
                $anonIssue->ward_id, 
                $anonIssue->street_id, 
                'leader', 
                1, 
                $request->category_id
            );
        }

        $anonIssue->save();

        return redirect()->route('anon-issues.index')->with('status', 'Issue updated successfully!');
    }


    public function destroy($id): RedirectResponse
    {
        AnonIssue::find($id)->delete();

        return Redirect::route('anon-issues.index')
            ->with('success', 'AnonIssue deleted successfully');
    }

    public function forward(Request $request, AnonIssue $anonIssue)
    {
        $request->validate([
            'forward_to' => 'required|exists:users,id',
        ]);

        if (auth()->user()->role != 'leader') {
            return redirect()->route('anon-issues.show', ['anon_issue' => $anonIssue->id])->with('error', 'Unauthorized action.');
        }

        $anonIssue->update([
            'to_user_id' => UserHelper::findMatchingByUserLocation($anonIssue->country_id, $anonIssue->region_id, $anonIssue->district_id, $anonIssue->ward_id, $anonIssue->street_id, 'leader', $request->forward_to, $anonIssue->category_id),
        ]);

        return redirect()->route('anon-issues.show', ['anon_issue' => $anonIssue->id])->with('success', 'Issue forwarded successfully.');
    }

    public function updateStatus(Request $request, AnonIssue $anon_issue)
    {

        if (auth()->user()->role != 'leader') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|string|in:open,inprogress,resolved,closed',
        ]);

        $anon_issue->update([
            'status' => $request->status,
            'sealed_by' => auth()->id(),
        ]);

        return redirect()->route('anon-issues.show', ['anon_issue' => $anon_issue->id])->with('success', 'Status updated successfully.');
    }

    public function updateVisibility(Request $request, AnonIssue $anon_issue)
    {
        if (auth()->user()->role != 'leader') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'visibility' => 'required|boolean',
        ]);

        $anon_issue->visibility = $request->visibility;
        $anon_issue->save();

        return redirect()->route('anon-issues.show', ['anon_issue' => $anon_issue->id])->with('success', 'Visibility updated successfully.');
    }
}
