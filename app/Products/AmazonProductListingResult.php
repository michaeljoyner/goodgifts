<?php


namespace App\Products;


abstract class AmazonProductListingResult
{
    private $xml;

    public function __construct($xml)
    {
        $this->xml = $xml;
    }

    public function getProducts()
    {
        $sxl = new \SimpleXMLElement($this->xml);

        $prods = [];
        foreach ($sxl->Items->Item as $item) {
            $prods[] = $item;
        }

        return collect($prods)->map(function ($item) {
            return new Product($this->extractProductAttributesFromSimpleXMLElement($item));
        });
    }

    protected function extractProductAttributesFromSimpleXMLElement($xmlElement)
    {
        return [
            'title'       => substr((string)$xmlElement->ItemAttributes->Title, 0, 180),
            'link'        => (string)$xmlElement->DetailPageURL,
            'image'       => $this->extractPrimaryLargeImageSrcFromItem($xmlElement),
            'description' => (string)$xmlElement->EditorialReviews->EditorialReview->Content,
            'price'       => (string)$xmlElement->ItemAttributes->ListPrice->FormattedPrice,
            'itemid' => (string)$xmlElement->ASIN
        ];
    }

    protected function extractPrimaryLargeImageSrcFromItem($xmlElement)
    {
        return collect($xmlElement->ImageSets->ImageSet)->filter(function ($set) {
            return (string)$set->attributes()['Category'] === 'primary';
        })->map(function ($set) {
            return (string)$set->LargeImage->URL;
        })->first();
    }
}