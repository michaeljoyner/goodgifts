<?php


namespace App\Analytics;


use Carbon\Carbon;

abstract class AnalyticsData
{
    public abstract function visitorsAndPageViews();

    public static function getYearOfMonthsEndingNow()
    {
        return collect(range(0,11))->map(function($monthCount) {
            return Carbon::parse('-' . $monthCount . ' months')->format('M Y');
        })->reverse()->values()->toArray();
    }

    protected static function makeDataSet($data, $label, $colour = [0,0,0])
    {
        return [
            'label' => $label,
            'data' => $data,
            'fill' =>  true,
            'lineTension' =>  0.1,
            'backgroundColor' =>  sprintf("rgba(%s,%s,%s,0.4)", ...$colour),
            'borderColor' =>  sprintf("rgba(%s,%s,%s,1)", ...$colour),
            'borderCapStyle' =>  'butt',
            'borderDash' =>  [],
            'borderDashOffset' =>  0.0,
            'borderJoinStyle' =>  'miter',
            'pointBorderColor' =>  sprintf("rgba(%s,%s,%s,1)", ...$colour),
            'pointBackgroundColor' =>  "#fff",
            'pointBorderWidth' =>  1,
            'pointHoverRadius' =>  5,
            'pointHoverBackgroundColor' =>  sprintf("rgba(%s,%s,%s,1)", ...$colour),
            'pointHoverBorderColor' =>  "rgba(220,220,220,1)",
            'pointHoverBorderWidth' =>  2,
            'pointRadius' =>  1,
            'pointHitRadius' =>  10,
        ];
    }
}