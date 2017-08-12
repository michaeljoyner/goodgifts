<?php


namespace Tests\Unit\GiftLists;


use App\GiftLists\GiftList;
use App\GiftLists\GiftListPresenter;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PresentedGiftListsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function it_presents_the_request_senders_name()
    {
        $list = factory(GiftList::class)->create();
        $presented_list = $list->present(GiftListPresenter::class);

        $this->assertEquals($list->request->sender, $presented_list->requested_by);
    }

    /**
     *@test
     */
    public function it_presents_the_request_recipients_name()
    {
        $list = factory(GiftList::class)->create();
        $presented_list = $list->present(GiftListPresenter::class);

        $this->assertEquals($list->request->recipient, $presented_list->for);
    }

    /**
     *@test
     */
    public function it_presents_the_budget()
    {
        $list = factory(GiftList::class)->create();
        $presented_list = $list->present(GiftListPresenter::class);

        $this->assertEquals($list->request->budgetLimit(), $presented_list->budget);
    }

    /**
     *@test
     */
    public function it_presents_the_list_of_given_interests()
    {
        $list = factory(GiftList::class)->create();
        $presented_list = $list->present(GiftListPresenter::class);

        $this->assertEquals($list->request->interests, $presented_list->interests);
    }
}