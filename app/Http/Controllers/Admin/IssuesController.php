<?php

namespace App\Http\Controllers\Admin;

use App\Issues\BatchUpdateIssue;
use App\Issues\IncompleteUpdateIssue;
use App\Issues\Issue;
use App\Issues\UnavailableProductIssue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IssuesController extends Controller
{
    public function index()
    {
        $this->pruneIssues();
        $issues = Issue::latest()->get();
        return view('admin.issues.index')->with(compact('issues'));
    }

    public function show($issue)
    {
        $issue = Issue::find($issue);

        if(! $issue) {
            return redirect('/admin/issues');
        }

        return view('admin.issues.show')->with(compact('issue'));
    }

    public function delete(Issue $issue)
    {
        $issue->delete();

        return redirect('admin/issues');
    }

    private function pruneIssues()
    {
        UnavailableProductIssue::pruneDuplicates();
        BatchUpdateIssue::clearOlderThan();
        IncompleteUpdateIssue::clearOlderThan();
    }
}
