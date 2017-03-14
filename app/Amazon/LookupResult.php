<?php


namespace App\Amazon;


use App\Products\Product;

class LookupResult
{
    private $xml;
    
    public function __construct($xml)
    {
        $this->xml = $xml;
    }

    public function getProduct()
    {
        $sxl = new \SimpleXMLElement($this->xml);

        $prods = [];
        foreach ($sxl->Items->Item as $item) {
            $prods[] = $item;
        }

        return collect($prods)->map(function ($item) {
            return new Product($this->extractProductAttributesFromSimpleXMLElement($item));
        })->first();
    }

    protected function extractProductAttributesFromSimpleXMLElement($xmlElement)
    {
        return [
            'title'       => (string)$xmlElement->ItemAttributes->Title,
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