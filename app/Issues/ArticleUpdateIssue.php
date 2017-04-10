<?php

namespace App\Issues;

use Illuminate\Database\Eloquent\Model;

class ArticleUpdateIssue extends Model
{
    use Resolvable;

    protected $table = 'article_update_issues';

    protected $fillable = ['product_id', 'article_id'];

}
