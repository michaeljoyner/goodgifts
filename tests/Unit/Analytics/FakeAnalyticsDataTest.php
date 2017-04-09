<?php

namespace Tests\Unit\Analytics;

use App\Analytics\FakeAnalyticsData;
use Tests\TestCase;

class FakeAnalyticsDataTest extends TestCase
{
    /**
     *@test
     */
    public function it_returns_fake_data_for_visitors_and_pageviews()
    {
        $analytics = new FakeAnalyticsData();

        $result = $analytics->visitorsAndPageViews();

        $this->assertArrayHasKey('labels', $result);
        $this->assertArrayHasKey('datasets', $result);
        $this->assertCount(2, $result['datasets']);

        $pageViews = $result['datasets'][0];
        $visitors = $result['datasets'][1];

        $this->assertEquals([200,200,200,200,200,200,200,200,200,200,200,200], $pageViews['data']);
        $this->assertEquals([100,100,100,100,100,100,100,100,100,100,100,100], $visitors['data']);
        $this->assertEquals('Page Views', $pageViews['label']);
        $this->assertEquals('Visitors', $visitors['label']);
    }
}