<?php

namespace App\Issues;

use App\Products\Product;
use Illuminate\Database\Eloquent\Model;

class UnavailableProductIssue extends Model
{
    use Resolvable;

    protected $table = 'unavailable_product_issues';

    protected $fillable = ['product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public static function pruneDuplicates()
    {
        static::all()->groupBy('product_id')->each(function($group) {
           $group->sortByDesc('created_at')->values()->slice(1)->each(function($issue) {
               $issue->resolve();
           });
        });
    }
}
