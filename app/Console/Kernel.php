<?php

namespace App\Console;

use App\Console\Commands\GenerateSitemap;
use App\Console\Commands\SyncMentionedProducts;
use App\Console\Commands\UpdateArticleProducts;
use App\Console\Commands\UpdateProducts;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SyncMentionedProducts::class,
        GenerateSitemap::class,
        UpdateProducts::class,
        UpdateArticleProducts::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('sitemap:generate')->dailyAt('13:00');
        $schedule->command('article_products:sync')->dailyAt('14:00');
        $schedule->command('products:update')->dailyAt('15:00');
        $schedule->command('article_products:update')->dailyAt('16:00');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
