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
                'itemid' => $itemId,
                'available' => true
            ]);
        });
    }

    private function parseIds($id)
    {
       return collect(explode(',', $id))->map(function($id) {
            return $this->parseOutUrl($id);
        });
    }

    private function parseOutUrl($id) {
        if(starts_with($id, ['http://', 'https://'])) {
            return $this->extractProductId($id);
        }
        return $id;
    }

    private function extractProductId($id)
    {
        $matches = [];
        preg_match('/(?:dp|o|gp|-)\/(B[0-9]{2}[0-9A-Z]{7}|[0-9]{9}(?:X|[0-9]))/', $id, $matches);

        return $matches[1];
    }
}