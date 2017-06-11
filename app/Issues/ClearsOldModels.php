<?php


namespace App\Issues;


use Carbon\Carbon;

trait ClearsOldModels
{
    public static function clearOlderThan($hours = 12)
    {
        static::all()->filter(function($issue) use ($hours) {
            return $issue->created_at->lt(Carbon::now()->subHours($hours));
        })->each(function($issue) {
            $issue->resolve();
        });
    }
}