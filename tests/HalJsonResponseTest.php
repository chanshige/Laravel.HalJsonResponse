<?php

declare(strict_types=1);

namespace Chanshige\Laravel\Http;

use Chanshige\Laravel\Http\Fixtures\FakeHomeAction;

class HalJsonResponseTest extends BaseTestCase
{
    public function testHomeAction()
    {
        $response = $this->mockRun('/', FakeHomeAction::class);

        $expectedContent = <<<EOF
        {
            "message": "J.Y.Park",
            "_links": {
                "self": {
                    "href": "/"
                },
                "test": {
                    "href": "/test"
                }
            }
        }
        EOF;

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/hal+json', $response->headers->get('Content-Type'));
        $this->assertEquals($expectedContent, $response->getContent());
    }
}
