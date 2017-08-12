<?php


namespace Tests\Unit\Products;


use App\Products\Product;
use App\Tags\Tag;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ProductsMatchingTagsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function products_tagged_with_a_search_tag_are_found()
    {
        $productA = factory(Product::class)->create();
        $productB = factory(Product::class)->create();
        $productC = factory(Product::class)->create();
        $productA->setTags(['FIND_ME']);
        $productB->setTags(['DONT_FIND_ME']);
        $productC->setTags(['FIND_ME']);

        $matches = Tag::productsFor(['FIND_ME']);

        $this->assertCount(2, $matches);
        $this->assertContains($productA->id, $matches->pluck('id')->all());
        $this->assertContains($productC->id, $matches->pluck('id')->all());
        $this->assertNotContains($productB->id, $matches->pluck('id')->all());
    }

    /**
     *@test
     */
    public function products_that_match_at_least_one_of_the_search_tags_are_returned()
    {
        $productA = factory(Product::class)->create();
        $productB = factory(Product::class)->create();
        $productC = factory(Product::class)->create();
        $productA->setTags(['TEST_A', 'TEST_B', 'TEST_C']);
        $productB->setTags(['TEST_C', 'TEST_D', 'TEST_E']);
        $productC->setTags(['TEST_F', 'TEST_G', 'TEST_H']);

        $matches = Tag::productsFor(['NON_TAG', 'NO_MATCH', 'TEST_C']);

        $this->assertCount(2, $matches);
        $this->assertContains($productA->id, $matches->pluck('id')->all());
        $this->assertContains($productB->id, $matches->pluck('id')->all());
        $this->assertNotContains($productC->id, $matches->pluck('id')->all());
    }

    /**
     *@test
     */
    public function the_returned_products_do_not_contain_duplicates()
    {
        $productA = factory(Product::class)->create();
        $productB = factory(Product::class)->create();
        $productC = factory(Product::class)->create();
        $productA->setTags(['TEST_A', 'TEST_B', 'TEST_C']);
        $productB->setTags(['TEST_C', 'TEST_D', 'TEST_E']);
        $productC->setTags(['TEST_F', 'TEST_G', 'TEST_H']);

        $matches = Tag::productsFor(['TEST_A', 'TEST_C']);

        $this->assertCount(2, $matches);
        $this->assertContains($productA->id, $matches->pluck('id')->all());
        $this->assertContains($productB->id, $matches->pluck('id')->all());
        $this->assertNotContains($productC->id, $matches->pluck('id')->all());
    }

    /**
     *@test
     */
    public function the_products_returned_have_a_match_score_which_is_the_amount_of_tags_matched()
    {
        $productA = factory(Product::class)->create();
        $productB = factory(Product::class)->create();
        $productC = factory(Product::class)->create();
        $productA->setTags(['TEST_A', 'TEST_B', 'TEST_C']);
        $productB->setTags(['TEST_C', 'TEST_B', 'TEST_E']);
        $productC->setTags(['TEST_C', 'TEST_G', 'TEST_H']);

        $matches = Tag::productsFor(['TEST_A', 'TEST_B', 'TEST_C']);

        $this->assertCount(3, $matches);
        $this->assertContains($productA->id, $matches->pluck('id')->all());
        $this->assertContains($productB->id, $matches->pluck('id')->all());
        $this->assertContains($productB->id, $matches->pluck('id')->all());
        $matches->each(function($match) use ($productA, $productB, $productC) {
           if($match->id === $productA->id) {
               $this->assertEquals(3, $match->match_score);
           }
            if($match->id === $productB->id) {
                $this->assertEquals(2, $match->match_score);
            }
            if($match->id === $productC->id) {
                $this->assertEquals(1, $match->match_score);
            }
        });
    }

//    /**
//     *@test
//     */
//    public function matches_on_tags_are_case_insensitive()
//    {
//        $productA = factory(Product::class)->create();
//        $productB = factory(Product::class)->create();
//        $productC = factory(Product::class)->create();
//        $productA->setTags(['FIND_ME']);
//        $productB->setTags(['DONT_FIND_ME']);
//        $productC->setTags(['FIND_ME']);
//
//        $matches = Tag::productsFor(['find_me']);
//
//        $this->assertCount(2, $matches);
//        $this->assertContains($productA->id, $matches->pluck('id')->all());
//        $this->assertContains($productC->id, $matches->pluck('id')->all());
//        $this->assertNotContains($productB->id, $matches->pluck('id')->all());
//    }
}