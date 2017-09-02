<?php


namespace App\GiftLists;


use Hemp\Presenter\Presenter;

class GiftListNotificationPresenter extends Presenter
{
    public function getSubjectLineAttribute()
    {
        $sender = $this->model->request->sender;
        $recipient = $this->model->request->recipient;

        $format = $recipient ?
            "Hey %s, your gift list for %s is ready!" : "Hey %s, that gift list you asked for is ready!";

        return vsprintf($format, [$sender ?: 'there', $recipient]);
    }

    /**
     *@test
     */
    public function getIntroAttribute()
    {
        $writeup = $this->model->writeup;
        $recipient = $this->model->request->recipient;

        $default = "You didn't forget about %s did you? Of course you didn't. And neither did we.";

        if($writeup) {
            return $writeup;
        }

        return vsprintf($default, [$recipient ?: 'his big day']);
    }
}