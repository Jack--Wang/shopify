<?php

use NickyWoolf\Shopify\ShopifyWebhook;
use PHPUnit\Framework\TestCase;

class ShopifyWebhookTest extends TestCase
{
    /** @test */
    function verify_webhook_signed_by_shopify()
    {
        $secret = 'SHOPIFY-CLIENT-SECRET';
        $body = json_encode([
            'timestamp' => 1234567890,
            'local' => 'en',
            'protocol' => 'https://',
            'shop' => 'example.myshopify.com',
        ]);
        $header = base64_encode(hash_hmac('sha256', $body, $secret, true));

        $webhook = new ShopifyWebhook($secret);

        $this->assertTrue($webhook->verify($header, $body));
    }

    /** @test */
    function can_not_verify_webhook_signed_by_shopify_using_different_secrets()
    {
        $secret = 'SHOPIFY-CLIENT-SECRET';
        $differentSecret = 'DIFFERENT-CLIENT-SECRET';
        $body = json_encode([
            'timestamp' => 1234567890,
            'local' => 'en',
            'protocol' => 'https://',
            'shop' => 'example.myshopify.com',
        ]);
        $header = base64_encode(hash_hmac('sha256', $body, $secret, true));

        $webhook = new ShopifyWebhook($differentSecret);

        $this->assertFalse($webhook->verify($header, $body));
    }
}