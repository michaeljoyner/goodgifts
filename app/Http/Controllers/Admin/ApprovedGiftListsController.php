<?php

namespace App\Http\Controllers\Admin;

use App\GiftLists\GiftList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApprovedGiftListsController extends Controller
{
    public function store(GiftList $list)
    {
        $list->approve();
        return redirect('/admin/giftlists');
    }
}
