<?php


namespace App\Products;


class Product
{
    public $title;
    public $link;
    public $description;
    public $price;
    public $image;
    public $itemid;

    public function __construct($params)
    {
        $this->title = trim($params['title']);
        $this->price = trim($params['price']);
        $this->description = trim($params['description']);
        $this->link = trim($params['link']);
        $this->image = trim($params['image']);
        $this->itemid = trim($params['itemid']);
    }
}