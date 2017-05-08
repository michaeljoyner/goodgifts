<?php

namespace Tests\Unit\Recommendations;


use App\Recommendations\Request;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RequestTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_request_date_is_stored_as_date_of_next_birthday()
    {
        $request = Request::create([
            'email'     => 'joe@example.com',
            'sender'    => 'Joe Soap',
            'recipient' => 'Junior Soap',
            'birthday'  => Carbon::parse('+2 months')->format('m-d'),
            'interests' => 'running,jumping,masturbating'
        ]);

        $this->assertTrue(Carbon::parse('+2 months')->isSameDay($request->birthday));
    }

    /**
     *@test
     */
    public function if_request_birthday_is_still_upcoming__then_will_be_this_year()
    {
        $request = Request::create([
            'email'     => 'joe@example.com',
            'sender'    => 'Joe Soap',
            'recipient' => 'Junior Soap',
            'birthday'  => Carbon::parse('+2 months')->format('m-d'),
            'interests' => 'running,jumping,masturbating'
        ]);

        $this->assertTrue(Carbon::parse('+2 months')->isSameDay($request->birthday));
    }

    /**
     *@test
     */
    public function if_request_birthday_has_passed_in_current_year_it_will_be_for_next_year()
    {
        $request = Request::create([
            'email'     => 'joe@example.com',
            'sender'    => 'Joe Soap',
            'recipient' => 'Junior Soap',
            'birthday'  => Carbon::parse('-2 months')->format('m-d'),
            'interests' => 'running,jumping,masturbating'
        ]);

        $this->assertTrue(Carbon::parse('-2 months')->addYear()->isSameDay($request->birthday));
    }
}