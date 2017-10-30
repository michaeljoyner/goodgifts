<?php

namespace App\Http\Controllers;

use App\Products\Product;
use Illuminate\Http\Request;

class ProductServiceController extends Controller
{
    public function index()
    {
        return Product::get()->map->toJsonableArray();
    }
}
