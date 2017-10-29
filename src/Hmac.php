<?php

namespace NickyWoolf\Shopify;

class Hmac
{
    private $secret;

    public function __construct($secret)
    {
        $this->secret = $secret;
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