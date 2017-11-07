<?php

use NickyWoolf\Shopify\Calls;
use PHPUnit\Framework\TestCase;

class CallsTest extends TestCase
{
    /** @test */
    function get_number_of_calls_made()
    {
        $calls = new Calls('3/40');

        $this->assertEquals(3, $calls->made());
    }

    /** @test */
    function get_call_limit()
    {
        $calls = new Calls('3/40');

        $this->assertEquals(40, $calls->limit());
    }

    /** @test */
    function get_calls_left_before_limit_reached()
    {
        $calls = new Calls('3/40');

        $this->assertEquals(37, $calls->left());
    }

    /** @test */
    function not_maxed_if_calls_below_limit()
    {
        $calls = new Calls('3/40');

        $this->assertFalse($calls->maxed());
    }

    /** @test */
    function maxed_if_calls_at_limit()
    {
        $calls = new Calls('40/40');

        $this->assertTrue($calls->maxed());
    }

    /** @test */
    function maxed_if_calls_above_limit()
    {
        $calls = new Calls('41/40');

        $this->assertTrue($calls->maxed());
    }
}