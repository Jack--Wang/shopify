<?php

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use NickyWoolf\Shopify\Response;
use PHPUnit\Framework\TestCase;
use Zttp\ZttpResponse;

class ResponseTest extends TestCase
{
    /** @test */
    function extract_resource_from_response()
    {
        $body = json_encode(['resource' => '...']);
        $zttpResponse = new ZttpResponse(new GuzzleResponse(200, [], $body));
        $response = new Response('example.myshopify.com', $zttpResponse);

        $resource = $response->extract('resource');

        $this->assertEquals('...', $resource);
    }

    /** @test */
    function get_api_call_limit_from_response()
    {
        $callLimit = ['X-Shopify-Shop-Api-Call-Limit' => '13/40'];
        $zttpResponse = new ZttpResponse(new GuzzleResponse(200, $callLimit, json_encode(['resource' => '...'])));
        $response = new Response('example.myshopify.com', $zttpResponse);

        $calls = $response->calls();

        $this->assertEquals(13, $calls->made());
        $this->assertEquals(40, $calls->limit());
    }
}