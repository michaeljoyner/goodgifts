<?php

namespace Tests\Unit\Recommendations;


use App\Recommendations\Request;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RequestTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        Notification::fake();
    }

    /**
     *@test
     */
    public function a_request_date_is_stored_as_date_of_next_birthday()
    {
        $request = Request::create([
            'email'     => 'joe@example.com',
            'sender'    => 'Joe Soap',
            'recipient' => 'Junior Soap',
            'birthday'  => Carbon::now()->addMonths(2)->format('m-d'),
            'interests' => 'running,jumping,masturbating'
        ])->fresh();


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
        ])->fresh();

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
        ])->fresh();

        $this->assertTrue(Carbon::parse('-2 months')->addYear()->isSameDay($request->birthday));
    }

    /**
     *@test
     */
    public function a_request_can_return_its_interests_in_array_form()
    {
        $request = factory(Request::class)->create(['interests' => 'running,jumping , masturbating']);
        $expected = ['running', 'jumping', 'masturbating'];

        $this->assertEquals($expected, $request->interestsArray());
    }

    /**
     *@test
     */
    public function a_request_is_new_if_it_has_no_lists()
    {
        $request = factory(Request::class)->create(['interests' => 'running,jumping , masturbating']);
        $this->assertCount(0, $request->giftLists);

        $this->assertTrue($request->isNew());
    }

    /**
     *@test
     */
    public function a_request_with_a_birthday_more_than_20_days_in_the_future_has_a_good_send_date()
    {
        $request = factory(Request::class)->create(['birthday' => Carbon::parse('+10 months')->format('m-d')]);
        $this->assertEquals(
            Carbon::today()->addMonths(10)->subDays(20)->diffForHumans(),
            $request->fresh()->sendDate()
        );
    }

    /**
     *@test
     */
    public function a_request_with_a_birthday_within_the_next_20_days_has_an_appropriate_send_date()
    {
        $request = factory(Request::class)->create(['birthday' => Carbon::parse('+10 days')->format('m-d')]);
        $this->assertEquals('ASAP (10 days)', $request->fresh()->sendDate());
    }

    /**
     *@test
     */
    public function the_age_group_can_presented_as_a_range()
    {
        $young = factory(Request::class)->create(['age_group' => 'young']);
        $mid = factory(Request::class)->create(['age_group' => 'mid']);
        $mature = factory(Request::class)->create(['age_group' => 'mature']);
        $old = factory(Request::class)->create(['age_group' => 'old']);

        $this->assertEquals('16 - 24', $young->ageRange());
        $this->assertEquals('25 - 39', $mid->ageRange());
        $this->assertEquals('40 - 60', $mature->ageRange());
        $this->assertEquals('60+', $old->ageRange());
    }

    /**
     *@test
     */
    public function the_budget_can_be_fetched_as_a_limit()
    {
        $low = factory(Request::class)->create(['budget' => 'low']);
        $mid = factory(Request::class)->create(['budget' => 'mid']);
        $big = factory(Request::class)->create(['budget' => 'big']);
        $huge = factory(Request::class)->create(['budget' => 'huge']);
        $limitless = factory(Request::class)->create(['budget' => 'limitless']);

        $this->assertEquals('US$50', $low->budgetLimit());
        $this->assertEquals('US$100', $mid->budgetLimit());
        $this->assertEquals('US$500', $big->budgetLimit());
        $this->assertEquals('US$1500', $huge->budgetLimit());
        $this->assertEquals('No limit', $limitless->budgetLimit());
    }

    /**
     *@test
     */
    public function setting_the_birthday_attribute_to_a_carbon_instance_will_set_the_date_directly()
    {
        $request = factory(Request::class)->create();

        $request->birthday = Carbon::parse('-2 days');
        $request->save();

        $this->assertEquals(Carbon::parse('-2 days')->format('Y-m-d'), $request->birthday->format('Y-m-d'));
    }

    /**
     *@test
     */
    public function deleting_a_request_will_delete_any_attached_gift_lists()
    {
        $request = factory(Request::class)->create();

        $listA = $request->createGiftList();
        $listB = $request->createGiftList();

        $request->delete();

        $this->assertNull($listA->fresh());
        $this->assertNull($listB->fresh());
    }

    /**
     *@test
     */
    public function a_request_is_automatically_assigned_an_unsubscribe_token_when_created()
    {
        $request = factory(Request::class)->create();

        $this->assertNotNull($request->unsubscribe_token);
    }

    /**
     *@test
     */
    public function it_knows_how_many_requests_were_made_in_the_last_amount_of_given_days()
    {
        factory(Request::class)->create(['created_at' => Carbon::parse('-5 days')]);
        factory(Request::class)->create(['created_at' => Carbon::parse('-6 days')]);
        factory(Request::class)->create(['created_at' => Carbon::parse('-10 days')]);
        factory(Request::class)->create(['created_at' => Carbon::parse('-20 days')]);
        factory(Request::class)->create(['created_at' => Carbon::parse('-25 days')]);
        factory(Request::class)->create(['created_at' => Carbon::parse('-40 days')]);
        factory(Request::class)->create(['created_at' => Carbon::parse('-100 days')]);

        $this->assertEquals(2, Request::countFromRecentDays(7));
        $this->assertEquals(5, Request::countFromRecentDays(30));
        $this->assertEquals(6, Request::countFromRecentDays(90));
    }
}