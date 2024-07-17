<?php
namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Category;
use App\Models\IssueChat;
use App\Models\User;
use App\Models\Leader;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;

class IssueController extends Controller
{
    public function index()
    {
        $issues = Issue::with('category')->get();
        return view('issues.index', compact('issues'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('issues.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'file_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,txt|max:9048',
        ]);

        $filePath = null;
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('files', $fileName, 'public');
        }

        Issue::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'file_path' => $filePath,
            'status' => 'open',
            'visibility' => 0,
            'to_user_id' => UserHelper::findMatchingUserId(auth()->id(), 'leader', 1, $request->category_id),
            'citizen_satisfied' => null,
        ]);

        return redirect()->route('myissues')->with('success', 'Issue created successfully.');
    }

    public function show(Issue $issue)
    {
        $issue->load('chats.user');
        $leaders = Leader::all();
        return view('issues.show', compact('issue', 'leaders'));
    }


    public function edit(Issue $issue)
    {
        $categories = Category::all();
        return view('issues.edit', compact('issue', 'categories'));
    }

    public function update(Request $request, Issue $issue)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'file_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,txt|max:2048',
        ]);

        $filePath = $issue->file_path;
        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('files', 'public');

            if ($issue->file_path) {
                Storage::disk('public')->delete($anonIssue->file_path);
            }
        }

        $issue->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'file_path' => $filePath,
        ]);

        return redirect()->route('issues.show', $issue->id)->with('success', 'Issue updated successfully.');
    }

    public function destroy(Issue $issue)
    {
        if ($issue->file_path) {
            Storage::disk('public')->delete($issue->file_path);
        }

        $issue->delete();
        return redirect()->route('issues.index')->with('success', 'Issue deleted successfully.');
    }

    public function reopen(Request $request, Issue $issue)
    {
        if ($issue->user_id != auth()->id()) {
            return redirect()->route('issues.show', $issue->id)->with('error', 'Unauthorized action.');
        }

        $issue->update(['status' => 'open']);
        return redirect()->route('issues.show', $issue->id)->with('success', 'Issue reopened successfully.');
    }

    public function rate(Request $request, Issue $issue)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        if ($issue->user_id != auth()->id() || $issue->status == 'open') {
            return redirect()->route('issues.show', $issue->id)->with('error', 'Unauthorized action.');
        }

        $issue->update(['citizen_satisfied' => $request->rating]);
        return redirect()->route('issues.show', $issue->id)->with('success', 'Service rated successfully.');
    }

    public function forward(Request $request, Issue $issue)
    {
        $request->validate([
            'forward_to' => 'required|exists:users,id',
        ]);

        if (auth()->user()->role != 'leader') {
            return redirect()->route('issues.show', $issue->id)->with('error', 'Unauthorized action.');
        }

        $issue->update([
            'to_user_id' => UserHelper::findMatchingUserId($issue->user_id, 'leader', $request->forward_to, $issue->category_id),
        ]);

        return redirect()->route('issues.show', $issue->id)->with('success', 'Issue forwarded successfully.');
    }

    public function updateStatus(Request $request, Issue $issue)
    {
        if (auth()->user()->role != 'leader') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|string|in:inprogress,resolved,closed',
        ]);

        $issue->status = $request->status;
        $issue->sealed_by = auth()->id();
        $issue->save();

        return redirect()->route('issues.show', $issue->id)->with('success', 'Status updated successfully.');
    }

    public function leaderIssues()
    {
        $issues = Issue::where('to_user_id', auth()->id())->orderBy('created_at', 'desc')->get();
        return view('issues.leader', compact('issues'));
    }

    public function myArea()
    {
        $leaderId = auth()->user()->id;
        $matchingIssueIds = UserHelper::findMatchingIssuesForLeader($leaderId);
        $issues = Issue::whereIn('id', $matchingIssueIds)->get();
        // print_r($issues);
        return view('issues.myarea', compact('issues'));
    }
}
