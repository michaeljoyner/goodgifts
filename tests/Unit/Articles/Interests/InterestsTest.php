<?php


namespace Tests\Unit\Interests;


use App\Interests\Interest;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class InterestsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_list_of_interests_can_be_created()
    {
        $interests = Interest::createList(collect(['running', 'jumping', 'testing']));

        $this->assertCount(3, $interests);

        $interests->each(function($interest) {
            $this->assertInstanceOf(Interest::class, $interest);
            $this->assertContains($interest->interest, ['running', 'jumping', 'testing']);
        });
    }

    /**
     *@test
     */
    public function create_list_returns_existing_interests_if_they_exist()
    {
        factory(Interest::class)->create(['interest' => 'running']);
        factory(Interest::class)->create(['interest' => 'jumping']);
        factory(Interest::class)->create(['interest' => 'testing']);

        $interests = Interest::createList(collect(['running', 'jumping', 'testing']));

        $this->assertCount(3, $interests);

        $interests->each(function($interest) {
            $this->assertInstanceOf(Interest::class, $interest);
            $this->assertContains($interest->interest, ['running', 'jumping', 'testing']);
        });

        $this->assertCount(3, Interest::all());

    }
}