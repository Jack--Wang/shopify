<?php

namespace NickyWoolf\Shopify;

class Webhook extends Hmac
{
    public function verify($header, $body)
    {
        return $header === base64_encode($this->hashRaw($body));
    }
}