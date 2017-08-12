<?php

namespace App\Http\Controllers\Admin;

use App\Suggestions\Suggestion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SuggestionsNameSearchController extends Controller
{
    public function index()
    {
        $this->validate(request(), ['name' => 'required']);

        return Suggestion::byProductName(request('name'));
    }
}
