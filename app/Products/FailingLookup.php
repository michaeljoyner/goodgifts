<?php


namespace App\Products;


class FailingLookup implements Lookup
{

    public function withId($id)
    {
        throw new \Exception('Failed product lookup from failing lookup');
    }
}