<?php

declare(strict_types=1);

namespace Chanshige\Laravel\Http;

use Chanshige\Laravel\Http\Fixtures\BodyLinksAction;
use Chanshige\Laravel\Http\Fixtures\IndexAction;
use Chanshige\Laravel\Http\Fixtures\NoContentAction;
use Chanshige\Laravel\Http\Fixtures\UserCreateAction;
use Koriym\HttpConstants\RequestHeader;
use Koriym\HttpConstants\StatusCode;

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

        $this->assertEquals(StatusCode::OK, $response->getStatusCode());
        $this->assertEquals('application/hal+json', $response->headers->get(RequestHeader::CONTENT_TYPE));
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

        $this->assertEquals(StatusCode::CREATED, $response->getStatusCode());
        $this->assertEquals('application/hal+json', $response->headers->get(RequestHeader::CONTENT_TYPE));
        $this->assertEquals($expectedContent, $response->getContent());
    }

    public function testNoContentAction()
    {
        $response = $this->mockRun('/no-content', NoContentAction::class);

        $this->assertEquals(StatusCode::NO_CONTENT, $response->getStatusCode());
        // コンテンツを返さないのでContent-Typeのテストはしない
        $this->assertEquals('', $response->getContent());
    }

    public function testBodyLinksAction()
    {
        $response = $this->mockRun('/links', BodyLinksAction::class);
        $expectedContent = <<<EOF
        {
            "greeting": "Hi! hyper media.",
            "_links": {
                "self": {
                    "href": "/links"
                },
                "test": {
                    "href": "/body_link"
                },
                "bttf": {
                    "href": "/back_in_time"
                }
            }
        }
        EOF;

        $this->assertEquals(StatusCode::OK, $response->getStatusCode());
        $this->assertEquals('application/hal+json', $response->headers->get(RequestHeader::CONTENT_TYPE));
        $this->assertEquals($expectedContent, $response->getContent());
    }
}
