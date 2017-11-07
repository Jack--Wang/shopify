<?php

namespace NickyWoolf\Shopify;

class Response
{
    private $shop;

    private $response;

    public function __construct($shop, $response)
    {
        $this->shop = $shop;
        $this->response = $response;
    }

    public function callLimitHeader()
    {
       return $this->getHeaderLine('X-Shopify-Shop-Api-Call-Limit');
    }

    public function calls()
    {
        return Calls::forShop($this->shop)->setHeader($this->callLimitHeader());
    }

    public function extract($key)
    {
        return $this->json()[$key];
    }

    public function __call($method, $args)
    {
        return $this->response->{$method}(...$args);
    }
}