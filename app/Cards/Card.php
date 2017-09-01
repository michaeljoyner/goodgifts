<?php

namespace App\Cards;

use App\Events\CardDeleted;
use App\Products\Product;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'cards';

    protected $fillable = ['product_id'];

    protected $dispatchesEvents = [
        'deleted' => CardDeleted::class
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
