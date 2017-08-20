<?php

namespace Tests\Unit\GiftLists;

use App\GiftLists\GiftList;
use App\Recommendations\Request;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RequestGiftListTest extends TestCase
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
    public function a_gift_list_can_be_created_from_a_recommendation_request()
    {
        $recommendation_request = factory(Request::class)->create();

        $list = $recommendation_request->createGiftList();

        $this->assertInstanceOf(GiftList::class, $list);
        $this->assertEquals($list->request_id, $recommendation_request->id);
    }
}