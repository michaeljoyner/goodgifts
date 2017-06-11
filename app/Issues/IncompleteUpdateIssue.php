<?php


namespace App\Issues;


use Illuminate\Database\Eloquent\Model;

class IncompleteUpdateIssue extends Model
{
    use HasIssueProducts, Resolvable, ClearsOldModels;

    protected $table = 'incomplete_update_issues';

    protected $fillable = ['product_ids'];
}