<?php


namespace App\Amazon;



use App\Products\Lookup;
use GuzzleHttp\Client;

class ProductLookup implements Lookup
{

    public function withId($id)
    {
        $itemid = $this->extractId($id);

        $req = new \App\Amazon\Request(env('AMAZON_SECRET_ACCESS_KEY'),[
            'Service' => 'AWSECommerceService',
            'Operation' => 'ItemLookup',
            'AWSAccessKeyId' => env('AMAZON_ACCESS_KEY_ID'),
            'AssociateTag' => env('AMAZON_ASSOC_TAG')
        ]);

        $client = new Client();

        $response = $client->get($req->url(['ItemId' => $itemid, 'ResponseGroup' => 'Images,Large']));

        return (new LookupResult($response->getBody()->getContents()))->getProduct();
    }

    private function extractId($url)
    {
        $matches = [];
        preg_match('/(?:dp|o|gp|-)\/(B[0-9]{2}[0-9A-Z]{7}|[0-9]{9}(?:X|[0-9]))/', $url, $matches);

        return $matches[1];
    }
}