<?php

use NickyWoolf\Shopify\ShopifyRequest;
use PHPUnit\Framework\TestCase;

class ShopifyRequestTest extends TestCase
{
    /** @test */
    function verify_request_signed_by_shopify()
    {
        $secret = 'SHOPIFY-CLIENT-SECRET';
        $requestData = [
            'timestamp' => 1234567890,
            'local' => 'en',
            'protocol' => 'https://',
            'shop' => 'example.myshopify.com',
            'hmac' => hash_hmac(
                'sha256', 'local=en&protocol=https://&shop=example.myshopify.com&timestamp=1234567890', $secret
            ),
        ];

        $request = new ShopifyRequest($secret);

        $this->assertTrue($request->verify($requestData));
    }

    /** @test */
    function can_not_verify_request_signed_by_shopify_without_hmac_in_request_data()
    {
        $secret = 'SHOPIFY-CLIENT-SECRET';
        $requestData = [
            'timestamp' => 1234567890,
            'local' => 'en',
            'protocol' => 'https://',
            'shop' => 'example.myshopify.com',
        ];

        $request = new ShopifyRequest($secret);

        $this->assertFalse($request->verify($requestData));
    }

    /** @test */
    function can_not_verify_request_signed_by_shopify_when_using_different_secrets()
    {
        $secret = 'SHOPIFY-CLIENT-SECRET';
        $differentSecret = 'DIFFERENT-CLIENT-SECRET';
        $requestData = [
            'timestamp' => 1234567890,
            'local' => 'en',
            'protocol' => 'https://',
            'shop' => 'example.myshopify.com',
            'hmac' => hash_hmac(
                'sha256', 'local=en&protocol=https://&shop=example.myshopify.com&timestamp=1234567890', $differentSecret
            ),
        ];

        $request = new ShopifyRequest($secret);

        $this->assertFalse($request->verify($requestData));
    }
}