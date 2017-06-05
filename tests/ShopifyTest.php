<?php

use NickyWoolf\Shopify\Shopify;
use PHPUnit\Framework\TestCase;

class ShopifyTest extends TestCase
{
    /** @test */
    function build_oauth_authorization_url()
    {
        $shopify = new Shopify('example.myshopify.com');

        $authUrl = $shopify->authorize('CLIENT-ID', 'SCOPE', 'REDIRECT-URI', 'STATE');

        $this->assertEquals(
            'https://example.myshopify.com/admin/oauth/authorize?client_id=CLIENT-ID&scope=SCOPE&redirect_uri=REDIRECT-URI&state=STATE',
            $authUrl
        );
    }
}