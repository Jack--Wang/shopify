<?php

namespace NickyWoolf\Shopify;

class Response
{
    private $response;

    public function __construct($response)
    {
        $this->response = $response;
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