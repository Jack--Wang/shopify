<?php

namespace  NickyWoolf\Shopify;

class Request extends Hmac
{
    public function verify($data)
    {
        if (! array_key_exists('hmac', $data)) {
            return false;
        }

        return $data['hmac'] === $this->sign($data);
    }

    public function sign($data)
    {
        ksort($data);

        $filtered = array_filter($data, function ($key) {
            return ! in_array($key, ['hmac', 'signature']);
        }, ARRAY_FILTER_USE_KEY);

        return $this->hash(urldecode(http_build_query($filtered)));
    }
}