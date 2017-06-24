<?php


namespace App\Recommendations;


use Carbon\Carbon;
use Hemp\Presenter\Presenter;

class PresentedRequest extends Presenter
{

    public function getSenderAttribute()
    {
        return $this->model->sender ?: 'Hey';
    }

    public function getRecipientAttribute()
    {
        return $this->model->recipient ?: 'you';
    }

    public function getWhiteboardWordAttribute()
    {
        return $this->model->recipient ? '"' . $this->model->recipient . '"': 'something';
    }

    public function getMailDateAttribute()
    {
        if($this->model->birthday->subDays(30)->lt(Carbon::now())) {
            return 'soon';
        }
        return 'on ' . $this->model->birthday->subDays(30)->toFormattedDateString();
    }
}