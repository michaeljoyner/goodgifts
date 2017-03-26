<?php


namespace App\Amazon;


class AmazonId
{
    public static function fromUrl($url)
    {
        $matches = [];
        preg_match('/(?:dp|o|gp|-)\/(B[0-9]{2}[0-9A-Z]{7}|[0-9]{9}(?:X|[0-9]))/', $url, $matches);

        return $matches[1];
    }

    public static function parse($id)
    {
        if(starts_with($id, ['http://', 'https://'])) {
            return static::fromUrl($id);
        }
        return $id;
    }
}