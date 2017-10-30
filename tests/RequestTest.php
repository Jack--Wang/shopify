<?php

use NickyWoolf\Shopify\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
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

        $request = new Request($secret);

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

        $request = new Request($secret);

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

        $request = new Request($secret);

        $this->assertFalse($request->verify($requestData));
    }

    /** @test */
    function signs_request()
    {
        $secret = 'SHOPIFY-CLIENT-SECRET';
        $requestData = [
            'timestamp' => 1234567890,
            'local' => 'en',
            'protocol' => 'https://',
            'shop' => 'example.myshopify.com',
        ];
        $request = new Request($secret);

        $requestData['hmac'] = $request->sign($requestData);

        $this->assertTrue($request->verify($requestData));
    }

    /** @test */
    function signed_request_not_verified_with_different_secrets()
    {
        $requestData = [
            'timestamp' => 1234567890,
            'local' => 'en',
            'protocol' => 'https://',
            'shop' => 'example.myshopify.com',
        ];
        $request = new Request('SHOPIFY-CLIENT-SECRET');

        $requestData['hmac'] = $request->sign($requestData);

        $this->assertFalse((new Request('INVALID-SECRET'))->verify($requestData));
    }
}