<?php

namespace App\Listeners;

use App\Events\CardDeleted;
use App\Products\Product;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClearDeletedCardProduct
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CardDeleted  $event
     * @return void
     */
    public function handle(CardDeleted $event)
    {
        $product = Product::find($event->card->product_id);

        if($product) {
            $product->delete();
        }
    }
}
