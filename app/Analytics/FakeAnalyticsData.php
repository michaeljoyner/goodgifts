<?php


namespace App\Analytics;


use Carbon\Carbon;

class FakeAnalyticsData extends AnalyticsData
{

    public function visitorsAndPageViews()
    {
        $pageViews = [200, 200, 200, 200, 200, 200, 200, 200, 200, 200, 200, 200];
        $visitors = [100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100];

        return [
            'labels'   => static::getYearOfMonthsEndingNow(),
            'datasets' => [
                $this->makeDataSet($pageViews, 'Page Views', [100, 35, 98]),
                $this->makeDataSet($visitors, 'Visitors', [240, 235, 98]),
            ]
        ];
    }


}