<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NotifyOfProductUpdateIssue extends Notification
{
    use Queueable;

    public $issue;

    public function __construct($issue)
    {
        $this->issue = $issue;
    }


    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toSlack($notifiable)
    {
        return (new SlackMessage)
            ->to('#issues')
            ->error()
            ->content(class_basename($this->issue->issue_type))
            ->attachment(function ($attachment) {
                $attachment->title('It is an issue', url('/admin/issues/' . $this->issue->id))
                    ->content($this->issue->message);
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
