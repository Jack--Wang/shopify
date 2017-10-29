<?php

namespace NickyWoolf\Shopify;

use Zttp\Zttp;

class Shopify
{
    private $myshopifyDomain;

    private $accessToken;

    public function __construct($myshopifyDomain, $accessToken = null)
    {
        $this->myshopifyDomain = $myshopifyDomain;
        $this->accessToken = $accessToken;
    }

    public function authorize($client_id, $scope, $redirect_uri, $state = null)
    {
        if (is_array($scope)) {
            $scope = implode(',', $scope);
        }

        $query = http_build_query(compact(
            'client_id', 'scope', 'redirect_uri', 'state'
        ));

        return $this->endpoint("oauth/authorize?{$query}");
    }

    public function client()
    {
        return Zttp::withHeaders([
            'X-Shopify-Access-Token' => $this->accessToken,
        ]);
    }

    public function endpoint($uri)
    {
        return "https://{$this->myshopifyDomain}/admin/{$uri}";
    }

    public function send($method, $url, $params = [])
    {
        return new Response($this->client()->{$method}($this->endpoint($url), $params));
    }

    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    public function __call($method, $args)
    {
        return $this->send($method, ...$args);
    }
}

