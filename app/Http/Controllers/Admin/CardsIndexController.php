<?php

namespace App\Http\Controllers\Admin;

use App\Cards\Card;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CardsIndexController extends Controller
{
    public function index()
    {
        return Card::latest()->get()->map(function($card) {
            return [
                'image' => $card->product->image,
                'link' => $card->product->link,
                'price' => $card->product->price,
                'id' => $card->id
            ];
        })->toArray();
    }
}
