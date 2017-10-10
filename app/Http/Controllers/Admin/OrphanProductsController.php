<?php

namespace App\Http\Controllers\Admin;

use App\Products\TaggingIssuesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrphanProductsController extends Controller
{
    public function delete(TaggingIssuesRepository $repository)
    {
        $repository->orphanProducts()->each->delete();

        return redirect('/admin/tags/issues');
    }
}
