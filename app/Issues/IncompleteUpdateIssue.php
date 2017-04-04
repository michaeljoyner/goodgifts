<?php


namespace App\Issues;


use Illuminate\Database\Eloquent\Model;

class IncompleteUpdateIssue extends Model
{
    use HasIssueProducts;

    protected $table = 'incomplete_update_issues';

    protected $fillable = ['product_ids'];
}