<?php

namespace App\Http\Controllers\Admin;

use App\Tags\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagsController extends Controller
{
    public function index()
    {
        return Tag::all()->map(function($tag) {
            return ['id' => $tag->id, 'name' => $tag->tag];
        });
    }
}
