<?php


namespace App\Products;


use GuzzleHttp\Client;

class AmazonProductSearch implements ProductSearch
{
    public function for($params)
    {
        $req = new \App\Amazon\Request(env('AMAZON_SECRET_ACCESS_KEY'),[
            'Service' => 'AWSECommerceService',
            'Operation' => 'ItemSearch',
            'ResponseGroup' => 'Images,Large',
            'AWSAccessKeyId' => env('AMAZON_ACCESS_KEY_ID'),
            'AssociateTag' => env('AMAZON_ASSOC_TAG')
        ]);

        $client = new Client();

        $response = $client->get($req->url($params));

        $searchResults = new AmazonSearchResults($response->getBody()->getContents());

        return $searchResults->getProducts();
    }
}