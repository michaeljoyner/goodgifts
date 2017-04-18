<?php


namespace App\Amazon;


use App\Products\SimilarSearch;
use GuzzleHttp\Client;

class AmazonSimilarSearch implements SimilarSearch
{

    public function for ($itemid)
    {
        $itemid = AmazonId::parse($itemid);

        $req = new \App\Amazon\Request(env('AMAZON_SECRET_ACCESS_KEY'),[
            'Service' => 'AWSECommerceService',
            'Operation' => 'SimilarityLookup',
            'AWSAccessKeyId' => env('AMAZON_ACCESS_KEY_ID'),
            'AssociateTag' => env('AMAZON_ASSOC_TAG')
        ]);

        $client = new Client();

        $response = $client->get($req->url(['ItemId' => $itemid, 'ResponseGroup' => 'Images,Large']));

        return (new LookupResult($response->getBody()->getContents()))->getProducts();
    }
}