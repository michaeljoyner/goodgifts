<?php

namespace App\Http\Controllers\Admin;

use App\Suggestions\Suggestion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SuggestionsTagSearchController extends Controller
{
    public function index()
    {
        $this->validate(request(), ['tags' => 'required|array']);

        return Suggestion::forTags(request('tags'));
    }
}
