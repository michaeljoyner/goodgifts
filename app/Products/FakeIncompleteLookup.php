<?php


namespace App\Products;


class FakeIncompleteLookup implements Lookup
{

    public function withId($id)
    {
        $ids = $this->parseIds($id);

        if(count($ids) < 2) {
            throw new \Exception('Fake incomplete lookup needs at least two itemids');
        }



        return collect($ids)->filter(function($id, $index) {
            return ($index > 0) && ($index % 2 !== 0);
        })->map(function($itemId) {
            return new Product([
                'title' => 'Fake title',
                'link' => 'Fake link',
                'description' => 'Fake description',
                'image' => 'Fake image',
                'price' => 'Fake price',
                'itemid' => $itemId,
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