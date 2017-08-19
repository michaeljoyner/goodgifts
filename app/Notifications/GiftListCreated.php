<?php

namespace App\Notifications;

use App\GiftLists\GiftListPresenter;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class GiftListCreated extends Notification
{
    use Queueable;


    public $list;

    public function __construct($list)
    {
        $this->list = $list;
    }


    public function via($notifiable)
    {
        return ['slack'];
    }

    public function toSlack($notifiable)
    {
        $presented_list = $this->list->present(GiftListPresenter::class);
        return (new SlackMessage)
            ->from('Good Gifts For Guys')
            ->image('https://goodgiftsforguys.com/android-chrome-192x192.png')
            ->success()
            ->content('A new gift list has been requested!')
            ->attachment(function ($attachment) use ($presented_list) {
                $attachment->title('GiftList #' . $presented_list->id)
                    ->fields([
                        'Sender' => $presented_list->requested_by,
                        'For' => $presented_list->for,
                        'Via' => $presented_list->budget,
                        'Due By' => $presented_list->request->sendDate(),
                    ]);
            });
    }



    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
