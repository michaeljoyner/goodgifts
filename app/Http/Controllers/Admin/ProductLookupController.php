<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductLookupController extends Controller
{
    public function show(\App\Products\Lookup $lookup)
    {
        $this->validate(request(), ['itemid' => 'required']);

        return $lookup->withId(request('itemid'));
    }
}
