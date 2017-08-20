<?php

namespace App\Http\Controllers;

use App\GiftLists\GiftList;
use App\Recommendations\Request as RecommendationRequest;
use Illuminate\Http\Request;

class GiftListSubscriptionController extends Controller
{
    public function delete($slug)
    {
        $request = RecommendationRequest::where('unsubscribe_token', $slug)->firstOrFail();

        RecommendationRequest::where('email', $request->email)->get()->each->delete();

        return view('front.recommendations.goodbye');
    }
}
