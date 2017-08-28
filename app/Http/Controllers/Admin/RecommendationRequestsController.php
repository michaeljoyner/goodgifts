<?php

namespace App\Http\Controllers\Admin;

use App\Recommendations\Request as RecommendationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RecommendationRequestsController extends Controller
{
    public function index()
    {
        $signups = RecommendationRequest::latest()->limit(20)->get();
        $counts = [
            'week' => RecommendationRequest::countFromRecentDays(7),
            'month' => RecommendationRequest::countFromRecentDays(30),
            'three_months' => RecommendationRequest::countFromRecentDays(90)
        ];

        return view('admin.recommendations.requests.index', [
            'signups' => $signups,
            'counts' => $counts
        ]);
    }
}
