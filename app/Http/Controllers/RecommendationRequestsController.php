<?php

namespace App\Http\Controllers;

use App\Tags\Tag;
use Illuminate\Http\Request;

class RecommendationRequestsController extends Controller
{

    public function show()
    {
        $interests = Tag::orderBy('tag')->get();
        return view('front.recommendations.signup', ['interests' => $interests]);
    }

    public function store()
    {
        $this->validate(request(), [
            'email' => 'required|email',
            'interests' => 'required',
            'birthday_day' => ['required', 'regex:/^(0[1-9]|[12][0-9]|3[01])$/'],
            'birthday_month' => ['required', 'regex:/^(0[1-9]|1[0-2])$/']
        ]);

        \App\Recommendations\Request::create(array_merge(request()->only('email', 'interests', 'sender', 'recipient', 'budget', 'age_group'), ['birthday' => request('birthday_month') . '-' . request('birthday_day')]));

        return redirect('/recommendations/thanks');
    }

    public function thanks()
    {
        return view('front.recommendations.thanks');
    }
}
