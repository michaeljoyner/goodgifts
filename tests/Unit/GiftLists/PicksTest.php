<?php


namespace Tests\Unit\GiftLists;


use App\GiftLists\Pick;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PicksTest extends TestCase
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
    public function a_pick_can_be_presented_as_a_jsonable_array()
    {
        $pick = factory(Pick::class)->create();

        $expected = [
            'id' => $pick->id,
            'list_id' => $pick->gift_list_id,
            'suggestion_id' => $pick->suggestion_id,
            'top_pick' => $pick->top_pick,
            'product_name' => $pick->suggestion->product->title,
            'product_image' => $pick->suggestion->product->image,
            'price' => $pick->suggestion->product->price,
            'what' => $pick->suggestion->what,
            'why' => $pick->suggestion->why,
        ];

        $this->assertEquals($expected, $pick->toJsonableArray());
    }
}