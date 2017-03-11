<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GiftSearchController extends Controller
{
    public function index(Request $request, \App\Products\ProductSearch $search)
    {
        $gifts = $search->for($request->only('place', 'hobby'));
        return $gifts;
    }
}
