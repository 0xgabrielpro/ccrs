<?php

namespace App\Http\Controllers;

use App\Models\IssueChat;
use Illuminate\Http\Request;

class IssueChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $issueChats = IssueChat::all();
        return response()->json($issueChats);
    }

    /**
     * Store a newly created resource in storage.
     */

     public function store(Request $request)
     {
         $request->validate([
             'msg' => 'required|string|max:255',
             'issue_id' => 'required|exists:issues,id',
             'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,txt|max:2048',
         ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('files', $fileName, 'public');
        }
     
         $issueChat = new IssueChat([
             'msg' => $request->input('msg'),
             'issue_id' => $request->input('issue_id'),
             'user_id' => auth()->id(), 
             'file_path' => $filePath,
         ]);
     
         $issueChat->save();
     
         return redirect()->route('issues.show', $request->input('issue_id'))->with('success', 'Message sent successfully.');
     }
     


    /**
     * Display the specified resource.
     */
    public function show(IssueChat $issueChat)
    {
        return response()->json($issueChat);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IssueChat $issueChat)
    {
        $request->validate([
            'issue_id' => 'required|exists:issues,id',
            'msg' => 'required|string',
        ]);


        if ($issueChat->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $issueChat->update([
            'msg' => $request->input('msg'),
            'issue_id' => $request->input('issue_id'),
        ]);

        return response()->json($issueChat);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IssueChat $issueChat)
    {
        if ($issueChat->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $issueChat->delete();
        return response()->json(null, 204);
    }

}
