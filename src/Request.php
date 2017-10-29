<?php

namespace  NickyWoolf\Shopify;

class Request extends Hmac
{
    public function verify($data)
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
}