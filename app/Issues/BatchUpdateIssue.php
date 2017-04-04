<?php

namespace App\Issues;

use App\Products\Product;
use Illuminate\Database\Eloquent\Model;

class BatchUpdateIssue extends Model
{
    use HasIssueProducts;

    protected $table = 'batch_update_issues';

    protected $fillable = ['product_ids'];

}
