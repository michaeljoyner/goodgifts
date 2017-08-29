<?php

namespace App\Http\Controllers\Admin;

use App\Products\TaggingIssuesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaggingIssuesController extends Controller
{
    public function show(TaggingIssuesRepository $repository)
    {
        return view('admin.tags.issues', [
            'untagged'               => $repository->untaggedProducts(),
            'orphans'                => $repository->orphanProducts(),
            'unreasoned_suggestions' => $repository->unreasonedSuggestions()
        ]);
    }
}
