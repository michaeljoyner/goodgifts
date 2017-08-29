<?php


namespace Tests\Unit\Analytics;


use App\Analytics\GoogleAnalyticsData;
use Tests\TestCase;

class GoogleAnalyticsDataTest extends TestCase
{
    /**
     * @test
     * @integration
     */
    public function it_returns_the_correct_structure_for_visitors_and_page_views()
    {
        $analytics = new GoogleAnalyticsData();

        $result = $analytics->visitorsAndPageViews();
        $this->assertArrayHasKey('labels', $result);
        $this->assertArrayHasKey('datasets', $result);
        $this->assertCount(2, $result['datasets']);

        $pageViews = $result['datasets'][0];
        $visitors = $result['datasets'][1];

        $this->assertEquals('Page Views', $pageViews['label']);
        $this->assertEquals('Visitors', $visitors['label']);

        $this->assertCount(12, $pageViews['data']);
        $this->assertCount(12, $visitors['data']);

    }
}