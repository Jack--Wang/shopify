<?php

namespace NickyWoolf\Shopify;

class Hmac
{
    private $secret;

    public function __construct($secret)
    {
        $this->secret = $secret;
    }

    public function trustRequest($data)
    {
        if (! array_key_exists('hmac', $data)) {
            return false;
        }

        $filtered = array_filter($data, function ($key) {
            return ! in_array($key, ['hmac', 'signature']);
        }, ARRAY_FILTER_USE_KEY);

        $mapped = array_map(function ($key, $value) {
            return "{$key}={$value}";
        }, array_keys($filtered), array_values($filtered));

        sort($mapped);

        return $data['hmac'] === $this->hash(implode('&', $mapped));
    }

    public function trustWebhook($header, $body)
    {
        return $header === base64_encode($this->hashRaw($body));
    }

    protected function hashRaw($data)
    {
        return $this->hash($data, true);
    }

    protected function hash($data, $raw = false)
    {
        return hash_hmac('sha256', $data, $this->secret, $raw);
    }
}