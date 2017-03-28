<?php

namespace App\Console\Commands;

use App\Articles\Article;
use App\Products\Product;
use Illuminate\Console\Command;

class UpdateArticleProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'article_products:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update articles with current db products';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Article::all()->each(function($article) {
            collect($article->mentionedProducts())->map(function($mentionedProduct) {
                return Product::where('itemid', $mentionedProduct['itemid'])->first();
            })->filter(function($product) {
                return $product !== null;
            })->each(function($product) use ($article) {
                $article->updateBodyWithProduct($product);
            });
        });
    }
}
