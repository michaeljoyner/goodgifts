<?php

namespace App\Http\Controllers\Admin;

use App\Products\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeaturedProductsServiceController extends Controller
{
    public function index()
    {
        return Product::where('featured', true)->get()->map->toJsonableArray();
    }
}
