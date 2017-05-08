<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RecommendationRequestsController extends Controller
{
    public function index()
    {
        $signups = \App\Recommendations\Request::latest()->get();

        return view('admin.recommendations.requests.index')->with(compact('signups'));
    }
}
