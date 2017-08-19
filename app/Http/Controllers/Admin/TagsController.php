<?php

namespace App\Http\Controllers\Admin;

use App\Tags\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagsController extends Controller
{
    public function index()
    {
        return Tag::withCount('products')->get()->map(function($tag) {
            return ['id' => $tag->id, 'name' => $tag->tag, 'product_count' => $tag->products_count];
        });
    }

    public function delete()
    {
        $this->validate(request(), [
            'tags' => 'required|array',
            'tags.*' => 'integer|exists:tags,id'
        ]);

        collect(request('tags'))->each(function($tag_id) {
            $tag = Tag::find($tag_id);
            if($tag) {
                $tag->delete();
            }
        });
    }
}
