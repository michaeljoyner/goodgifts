<?php

namespace App\Console\Commands;

use App\Articles\Article;
use Illuminate\Console\Command;

class SyncMentionedProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'article_products:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Extracts mentioned products in articles and saves them to db if necessary';

    /**
     * Create a new command instance.
     *
     * @return void
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
            $article->syncMentionedProducts();
            $this->info('Synced ' . $article->title);
        });
    }
}
