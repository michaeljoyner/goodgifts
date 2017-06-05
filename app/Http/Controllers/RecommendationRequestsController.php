<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecommendationRequestsController extends Controller
{

    public function show()
    {
        return view('front.recommendations.signup');
    }

    public function store()
    {
        $this->validate(request(), [
            'email' => 'required|email',
            'interests' => 'required',
            'birthday' => ['required', 'regex:/^(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])$/']
        ]);

        \App\Recommendations\Request::create(request()->only('email', 'interests', 'birthday', 'sender', 'recipient', 'budget'));

        return response()->json('ok');
    }
}
