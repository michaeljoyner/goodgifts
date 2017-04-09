<?php


namespace Tests\Feature\Analytics;


use App\Analytics\AnalyticsData;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AnalyticsDataTest extends TestCase
{
    use DatabaseMigrations;
    /**
     *@test
     */
    public function monthly_visitor_and_page_view_data_can_be_fetched()
    {
        $this->disableExceptionHandling();
        $this->app->bind(\App\Analytics\AnalyticsData::class, function() {
            return new \App\Analytics\FakeAnalyticsData();
        });

        $response = $this->asLoggedInUser()->get('/admin/services/analytics/visitors');
        $response->assertStatus(200);

        $result = $response->decodeResponseJson();

        $this->assertEquals(AnalyticsData::getYearOfMonthsEndingNow(), $result['labels']);
        $this->assertCount(2, $result['datasets']);
        $this->assertEquals([100,100,100,100,100,100,100,100,100,100,100,100], $result['datasets'][1]['data']);
        $this->assertEquals('Page Views', $result['datasets'][0]['label']);
        $this->assertEquals([200,200,200,200,200,200,200,200,200,200,200,200], $result['datasets'][0]['data']);
        $this->assertEquals('Visitors', $result['datasets'][1]['label']);
    }
}