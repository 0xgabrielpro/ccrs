<?php
namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Category;
use App\Models\IssueChat;
use App\Models\User;
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
            'to_user_id' => UserHelper::findMatchingUserId(auth()->id(), 'leader', 1),
            'citizen_satisfied' => null,
        ]);
        var_dump(UserHelper::findMatchingUserId(auth()->id(), 'leader', 1));
        
        return redirect()->route('myissues')->with('success', 'Issue created successfully.');
    }

    public function show(Issue $issue)
    {
        $issue->load('chats.user');
        $leaders = User::where('role', 'leader')->get();
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
            'to_user_id' => UserHelper::findMatchingUserId($issue->user_id, 'leader', $request->forward_to),
        ]);

        return redirect()->route('issues.show', $issue->id)->with('success', 'Issue forwarded successfully.');
    }
}