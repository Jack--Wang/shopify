<?php

namespace NickyWoolf\Shopify;

class Calls
{
    protected $calls;

    protected $limit;

    public function __construct($callLimitHeader)
    {
        list($this->calls, $this->limit) = explode('/', $callLimitHeader);
    }

    public function left()
    {
        return $this->limit() - $this->made();
    }

    public function limit()
    {
        return $this->limit;
    }

    public function made()
    {
        return $this->calls;
    }

    public function maxed()
    {
        return $this->left() <= 0;
    }
}