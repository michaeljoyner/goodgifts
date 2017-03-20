<?php


namespace App\Products;


class FakeLookup implements Lookup
{
    public function withId($id)
    {
        $ids = $this->parseIds($id);

        return collect($ids)->map(function($itemId) {
            return new Product([
                'title' => 'Fake title',
                'link' => 'Fake link',
                'description' => 'Fake description',
                'image' => 'Fake image',
                'price' => 'Fake price',
                'itemid' => $itemId
            ]);
        });
    }

    private function parseIds($id)
    {
        return explode(',', $id);
    }
}