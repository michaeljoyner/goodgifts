<?php

namespace App\Http\Controllers\Admin;

use App\Issues\IncompleteUpdateIssue;
use App\Products\ProductUpdate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IncompleteUpdateIssueResolvingController extends Controller
{
    public function handle(IncompleteUpdateIssue $issue)
    {
        $issue->products()->each(function($product) {
            (new ProductUpdate(collect([$product])))->execute();
        });

        $issue->delete();
        return redirect('/admin/issues');
    }
}
