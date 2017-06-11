<?php

namespace App\Issues;

use App\Products\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BatchUpdateIssue extends Model
{
    use HasIssueProducts, Resolvable, ClearsOldModels;

    protected $table = 'batch_update_issues';

    protected $fillable = ['product_ids'];



}
