<?php


namespace Tests\Unit\Tags;


use App\Tags\Tag;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TagsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_tag_can_be_created()
    {
        $tag = factory(Tag::class)->create(['tag' => 'TEST TAG']);

        $this->assertInstanceOf(Tag::class, $tag);
        $this->assertEquals('TEST TAG', $tag->tag);
    }
}