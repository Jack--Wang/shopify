<?php

namespace NickyWoolf\Shopify;

class Calls
{
    protected static $shops = [];

    protected $shop;

    public static function forShop($shop)
    {
        return new static($shop);
    }

    public function __construct($shop)
    {
        $this->shop = $shop;

        if (! $this->getShopCalls()) {
            $this->setShopCalls(0, 0);
        }
    }

    public function left()
    {
        return $this->limit() - $this->made();
    }

    public function limit()
    {
        return $this->getShopCalls()->limit;
    }

    public function made()
    {
        return $this->getShopCalls()->calls;
    }

    public function maxed()
    {
        return $this->left() <= 0;
    }

    public function setHeader($callLimitHeader)
    {
        list($calls, $limit) = explode('/', $callLimitHeader);

        $this->setShopCalls($calls, $limit);

        return $this;
    }

    protected function setShopCalls($calls, $limit)
    {
        static::$shops[$this->shop] = (object) [
            'calls' => $calls,
            'limit' => $limit,
        ];

        return $this;
    }

    protected function getShopCalls()
    {
        return isset(static::$shops[$this->shop]) ? static::$shops[$this->shop] : null;
    }
}