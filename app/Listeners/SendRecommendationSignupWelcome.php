<?php

namespace App\Listeners;

use App\Events\RecommendationRequested;
use App\Mail\SignupWelcomeMail;
use App\Recommendations\PresentedRequest;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendRecommendationSignupWelcome
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  RecommendationRequested  $event
     * @return void
     */
    public function handle(RecommendationRequested $event)
    {
        Mail::to($event->request->email)->send(new SignupWelcomeMail(present($event->request, PresentedRequest::class)));
    }
}
