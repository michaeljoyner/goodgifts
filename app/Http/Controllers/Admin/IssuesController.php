<?php

namespace App\Http\Controllers\Admin;

use App\Issues\Issue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IssuesController extends Controller
{
    public function index()
    {
        $issues = Issue::latest()->get();
        return view('admin.issues.index')->with(compact('issues'));
    }

    public function show(Issue $issue)
    {
        return view('admin.issues.show')->with(compact('issue'));
    }

    public function delete(Issue $issue)
    {
        $issue->delete();

        return redirect('admin/issues');
    }
}
