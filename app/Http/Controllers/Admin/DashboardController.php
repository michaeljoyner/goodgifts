<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Analytics\Period;

class DashboardController extends Controller
{
    public function show()
    {

        $topPages = \Analytics::fetchMostVisitedPages(Period::days(365))->reject(function($page) {
            return starts_with($page['url'], '/admin');
        });

        return view('admin.dashboard')->with(compact('topPages'));
    }
}
