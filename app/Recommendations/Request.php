<?php

namespace App\Recommendations;

use App\Events\RecommendationRequested;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $table = 'requests';

    protected $fillable = ['email', 'interests', 'birthday', 'sender', 'recipient', 'budget', 'age_group'];

    protected $dates = ['birthday'];

    protected $events = [
        'created' => RecommendationRequested::class
    ];

    public function setBirthdayAttribute($birthday)
    {
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
}
