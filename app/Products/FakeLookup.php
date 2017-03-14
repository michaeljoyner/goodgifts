<?php


namespace App\Products;


class FakeLookup implements Lookup
{
    public function withId($id)
    {
        return new Product([
            'title' => 'Fake title',
            'link' => 'Fake link',
            'description' => 'Fake description',
            'image' => 'Fake image',
            'price' => 'Fake price',
            'itemid' => $id
        ]);
    }
}