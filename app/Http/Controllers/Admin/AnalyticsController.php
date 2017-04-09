<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnalyticsController extends Controller
{
    public function visitors(\App\Analytics\AnalyticsData $analyticsData)
    {
        return $analyticsData->visitorsAndPageViews();
    }
}
