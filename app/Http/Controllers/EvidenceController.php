<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class EvidenceController extends Controller
{
    public function download($file)
    {
        $filePath = 'files/' . $file;

        if (Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->download($filePath);
        }

        return redirect()->back()->with('error', 'File not found.');
    }
}
