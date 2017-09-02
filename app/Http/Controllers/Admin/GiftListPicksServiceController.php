<?php

namespace App\Http\Controllers\Admin;

use App\GiftLists\GiftList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GiftListPicksServiceController extends Controller
{
    public function index(GiftList $list)
    {
        return $list->picks->map->toJsonableArray();
    }
}
