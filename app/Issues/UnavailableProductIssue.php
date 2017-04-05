<?php

namespace App\Issues;

use App\Products\Product;
use Illuminate\Database\Eloquent\Model;

class UnavailableProductIssue extends Model
{
    protected $table = 'unavailable_product_issues';

    protected $fillable = ['product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
