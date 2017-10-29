<?php

namespace NickyWoolf\Shopify;

class ShopifyWebhook extends Hmac
{
    public function verify($header, $body)
    {
        return $header === base64_encode($this->hashRaw($body));
    }
}