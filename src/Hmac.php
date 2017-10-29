<?php

namespace NickyWoolf\Shopify;

abstract class Hmac
{
    private $secret;

    public function __construct($secret)
    {
        $this->secret = $secret;
    }

    protected function hash($data, $raw = false)
    {
        return hash_hmac('sha256', $data, $this->secret, $raw);
    }

    protected function hashRaw($data)
    {
        return $this->hash($data, true);
    }
}