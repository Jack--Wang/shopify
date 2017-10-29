<?php

use NickyWoolf\Shopify\Hmac;
use PHPUnit\Framework\TestCase;

class HmacTest extends TestCase
{

    /** @test */
    function check_valid_shopify_webhook()
    {
        $secret = 'SHOPIFY-CLIENT-SECRET';
        $body = json_encode([
            'timestamp' => 1234567890,
            'local' => 'en',
            'protocol' => 'https://',
            'shop' => 'example.myshopify.com',
        ]);
        $header = base64_encode(hash_hmac('sha256', $body, $secret, true));

        $hmac = new Hmac($secret);

        $this->assertTrue($hmac->trustWebhook($header, $body));
    }

    /** @test */
    function should_not_trust_webhook_signed_with_wrong_secret()
    {
        $secret = 'SHOPIFY-CLIENT-SECRET';
        $body = json_encode([
            'timestamp' => 1234567890,
            'local' => 'en',
            'protocol' => 'https://',
            'shop' => 'example.myshopify.com',
        ]);
        $header = base64_encode(hash_hmac('sha256', $body, 'A-WRONG-SECRET', true));

        $hmac = new Hmac($secret);

        $this->assertFalse($hmac->trustWebhook($header, $body));
    }
}