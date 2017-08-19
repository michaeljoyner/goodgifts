<?php


namespace Tests\Feature\GiftLists;


use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GiftListScheduleTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function the_schedule_can_give_all_lists_due_in_the_next_two_weeks()
    {

    }
}