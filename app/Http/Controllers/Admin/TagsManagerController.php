<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagsManagerController extends Controller
{
    public function show()
    {
        return view('admin.tags.manager');
    }
}
