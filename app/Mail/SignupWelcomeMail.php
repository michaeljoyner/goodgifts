<?php

namespace App\Mail;

use App\Recommendations\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SignupWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $request;


    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('There will be consequences')->markdown('emails.recommendations.welcome');
    }
}
