<?php

use NickyWoolf\Shopify\Calls;
use PHPUnit\Framework\TestCase;

class CallsTest extends TestCase
{
    /** @test */
    function get_number_of_calls_made()
    {
        $calls = Calls::forShop('example.myshopify.com')->setHeader('3/40');

        $this->assertEquals(3, $calls->made());
    }

    /** @test */
    function get_call_limit()
    {
        $calls = Calls::forShop('example.myshopify.com')->setHeader('3/40');

        $this->assertEquals(40, $calls->limit());
    }

    /** @test */
    function get_calls_left_before_limit_reached()
    {
        $calls = Calls::forShop('example.myshopify.com')->setHeader('3/40');

        $this->assertEquals(37, $calls->left());
    }

    /** @test */
    function not_maxed_if_calls_below_limit()
    {
        $calls = Calls::forShop('example.myshopify.com')->setHeader('3/40');

        $this->assertFalse($calls->maxed());
    }

    /** @test */
    function maxed_if_calls_at_limit()
    {
        $calls = Calls::forShop('example.myshopify.com')->setHeader('40/40');

        $this->assertTrue($calls->maxed());
    }

    /** @test */
    function maxed_if_calls_above_limit()
    {
        $calls = Calls::forShop('example.myshopify.com')->setHeader('41/40');

        $this->assertTrue($calls->maxed());
    }

    /** @test */
    function get_call_for_shop()
    {
        Calls::forShop('shop-a.myshopify.com')->setHeader('3/40');
        Calls::forShop('shop-b.myshopify.com')->setHeader('9/40');

        $calls = Calls::forShop('shop-a.myshopify.com');

        $this->assertEquals(3, $calls->made());
    }

    /** @test */
    function new_calls_is_at_limit_by_default()
    {
        $calls = new Calls('example.myshopify.com');

        $this->assertTrue($calls->maxed());
    }
}