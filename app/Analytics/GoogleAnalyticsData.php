<?php


namespace App\Analytics;


use Spatie\Analytics\Period;

class GoogleAnalyticsData extends AnalyticsData
{

    public function visitorsAndPageViews()
    {
        $data = \Analytics::fetchVisitorsAndPageViews(Period::days(365))->groupBy(function($item) {
            return $item['date']->format('M Y');
        })->map(function($month) {
            return [
                'pageViews' => $month->sum('pageViews'),
                'visitors' => $month->sum('visitors')
            ];
        });

        $pageViewArray = collect(static::getYearOfMonthsEndingNow())->map(function($month) use ($data) {
            return $data[$month]['pageViews'] ?? 0;
        })->toArray();

        $visitorArray = collect(static::getYearOfMonthsEndingNow())->map(function($month) use ($data) {
            return $data[$month]['visitors'] ?? 0;
        })->toArray();

        return [
            'labels' => static::getYearOfMonthsEndingNow(),
            'datasets' => [
                $this->makeDataSet($pageViewArray, 'Page Views', [222,131,10]),
                $this->makeDataSet($visitorArray, 'Visitors', [46,40,40])
            ]
        ];
    }


}