<?php

namespace App\Listeners;

use App\Events\ProductReplaced;
use App\Issues\UnavailableProductIssue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClearReplacedProductIssues
{

    public static $listensFor = [
        ProductReplaced::class
    ];


    public function __construct()
    {
        //
    }


    public function handle($event)
    {
        UnavailableProductIssue::where('product_id', $event->product->id)->get()->each->resolve();
    }
}
