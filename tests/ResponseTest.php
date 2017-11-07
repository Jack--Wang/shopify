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
        $response = new Response(new ZttpResponse(new GuzzleResponse(200, [], $body)));

        $resource = $response->extract('resource');

        $this->assertEquals('...', $resource);
    }
}