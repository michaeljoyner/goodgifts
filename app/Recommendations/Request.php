<?php

namespace App\Recommendations;

use App\Events\RecommendationRequestDeleted;
use App\Events\RecommendationRequested;
use App\GiftLists\GiftList;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $table = 'requests';

    protected $fillable = ['email', 'interests', 'birthday', 'sender', 'recipient', 'budget', 'age_group'];

    protected $dates = ['birthday'];

    protected $events = [
        'created' => RecommendationRequested::class,
        'deleting' => RecommendationRequestDeleted::class
    ];

    public function setBirthdayAttribute($birthday)
    {
        if($birthday instanceof Carbon) {
            return $this->attributes['birthday'] = $birthday;
        }

        $this->attributes['birthday'] = $this->nextBirthday($birthday);
    }

    protected function nextBirthday($date)
    {
        $month = intval(substr($date, 0, 2));
        $day = intval(substr($date, 3, 2));
        $now = Carbon::now();
        $this_year = new Carbon($now->year . '-' . $month . '-' . $day);
        $next_year = new Carbon(($now->year + 1) . '-' . $month . '-' . $day);
        return Carbon::today()->gt($this_year) ? $next_year : $this_year;
    }

    public function sendDate()
    {
        if ($this->birthday->lt(Carbon::today())) {
            return $this->birthday->addYear()->subDays(20)->diffForHumans();
        }

        if ($this->birthday->subDays(20)->lt(Carbon::today())) {
            return 'ASAP (' . $this->birthday->diffInDays(Carbon::today()) . ' days)';
        }

        return $this->birthday->subDays(20)->diffForHumans();
    }

    public function giftLists()
    {
        return $this->hasMany(GiftList::class, 'request_id');
    }

    public function createGiftList()
    {
        return $this->giftLists()->create([]);
    }

    public function isNew()
    {
        return $this->giftLists()->count() === 0;
    }

    public function interestsArray()
    {
        return collect(explode(',', $this->interests))->map(function($interest) {
            return trim($interest);
        })->all();
    }

    public function ageRange()
    {
        $ranges = [
            'young' => '16 - 24',
            'mid' => '25 - 39',
            'mature' => '40 - 60',
            'old' => '60+'
        ];

        return $ranges[$this->age_group] ?? 'Unknown';
    }

    public function budgetLimit()
    {
        $limits = [
            'low' => 'US$50',
            'mid' => 'US$100',
            'big' => 'US$500',
            'huge' => 'US$1500',
            'limitless' => 'No limit'
        ];

        return $limits[$this->budget] ?? 'Unknown';
    }
}
