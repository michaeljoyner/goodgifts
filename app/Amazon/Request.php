<?php

namespace App\Amazon;

class Request
{

    private $params;
    private $region;
    private $key;

    public function __construct($key, $params = [], $region = 'com')
    {
        $this->key = $key;
        $this->params = $params;
        $this->region = $region;
        $this->params['Timestamp'] = rawurlencode(gmdate('Y-m-d\TH:i:s\.000\Z'));
        ksort($this->params);
    }

    public function usingTimestamp($timestamp)
    {
        $this->params['Timestamp'] = $this->safeEncode($timestamp);
    }

    public function url($params = [])
    {
        if ($params) {
            $this->params = array_merge($this->params, $params);
            ksort($this->params);
        }
        $string = $this->sortedQueryString();

        $query = $string . '&' . 'Signature=' . $this->signature($string);

        return sprintf('http://webservices.amazon.%s/onca/xml?%s', $this->region, $query);
    }

    protected function sortedQueryString()
    {
        return collect($this->params)->map(function ($value, $key) {
            return collect($value)->sort()->reduce(function ($carry, $singleValue) use ($key) {
                return $this->glueParameters($carry, $key . '=' . $this->safeEncode($singleValue));
            }, '');
        })->reduce(function ($carry, $param) {
            return $this->glueParameters($carry, $param);
        }, '');
    }

    protected function glueParameters($parameterA, $parameterB)
    {
        return $parameterA . ($parameterA ? '&' : '') . $parameterB;
    }

    protected function signature($query)
    {
        return rawurlencode(
            base64_encode(
                hash_hmac(
                    "sha256",
                    $this->getSigningString($query),
                    $this->key,
                    true
                )
            )
        );
    }

    protected function getSigningString($query)
    {
        return 'GET' . PHP_EOL . 'webservices.amazon.' . $this->region . PHP_EOL . '/onca/xml' . PHP_EOL . $query;
    }

    protected function safeEncode($raw)
    {
        if (str_contains($raw, [',', ':', ' '])) {
            return rawurlencode($raw);
        }

        return $raw;
    }
}