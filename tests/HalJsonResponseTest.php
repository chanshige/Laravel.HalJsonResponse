<?php

declare(strict_types=1);

namespace Chanshige\Laravel\Http;

use Chanshige\Laravel\Http\Fixtures\IndexAction;
use Chanshige\Laravel\Http\Fixtures\UserCreateAction;

class HalJsonResponseTest extends BaseTestCase
{
    public function testIndexAction()
    {
        $response = $this->mockRun('/', IndexAction::class);

        $expectedContent = <<<EOF
        {
            "message": "Hi!",
            "user_id": 288781,
            "_links": {
                "self": {
                    "href": "/"
                },
                "user": {
                    "href": "/users/288781"
                }
            }
        }
        EOF;

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/hal+json', $response->headers->get('Content-Type'));
        $this->assertEquals($expectedContent, $response->getContent());
    }

    public function testUserCreateAction()
    {
        $response = $this->mockRun('/user/create', UserCreateAction::class);

        $expectedContent = <<<EOF
        {
            "id": 1989,
            "name": "shigeki",
            "_links": {
                "self": {
                    "href": "/user/create"
                },
                "user": {
                    "href": "/users/1989"
                }
            }
        }
        EOF;

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals('application/hal+json', $response->headers->get('Content-Type'));
        $this->assertEquals($expectedContent, $response->getContent());
    }
}
