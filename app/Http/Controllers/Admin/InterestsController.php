<?php

namespace App\Http\Controllers\Admin;

use App\Interests\Interest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InterestsController extends Controller
{
    public function index()
    {
        return Interest::all()->map(function($interest) {
            return ['id' => $interest->id, 'name' => $interest->interest];
        });
    }
}
