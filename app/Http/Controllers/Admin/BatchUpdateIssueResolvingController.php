<?php

namespace App\Http\Controllers\Admin;

use App\Issues\BatchUpdateIssue;
use App\Products\ProductUpdate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BatchUpdateIssueResolvingController extends Controller
{
    public function handle(BatchUpdateIssue $issue)
    {
        $issue->products()->each(function($product) {
            (new ProductUpdate(collect([$product])))->execute();
        });

        $issue->resolve();
        return redirect('/admin/issues');
    }
}
