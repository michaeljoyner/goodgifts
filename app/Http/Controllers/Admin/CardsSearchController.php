<?php

namespace App\Http\Controllers\Admin;

use App\Products\ProductSearch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CardsSearchController extends Controller
{
    public function index(ProductSearch $search)
    {
        $params = [
            'Sort' => 'reviewrank',
            'Keywords' => request('q', 'card') . ',cards,card',
            'SearchIndex' => 'OfficeProducts'
        ];
        return $search->for($params)->map(function($product) {
            $product->saved = false;
            return $product;
        });
    }

    public function show()
    {
        return view('admin.cards.search.show');
    }
}
