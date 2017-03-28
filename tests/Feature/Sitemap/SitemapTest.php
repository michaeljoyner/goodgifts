<?php


namespace Tests\Feature\Sitemap;


use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class SitemapTest extends TestCase
{
    /**
     *@test
     *@group integration
     */
    public function a_sitemap_file_is_generated_by_artisan_command()
    {
        $sitemapPath = public_path(config('services.sitemap.filename'));
        $this->assertFalse(file_exists($sitemapPath));

        Artisan::call('sitemap:generate');

        $this->assertTrue(file_exists($sitemapPath));

        if(file_exists($sitemapPath)) {
            unlink($sitemapPath);
        }
    }
}