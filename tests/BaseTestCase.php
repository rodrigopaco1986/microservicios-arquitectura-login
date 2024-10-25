<?php

namespace Tests;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Rpj\Login\Response;

class BaseTestCase extends TestCase
{
    protected $response = null;

    /**
     * Setup method that runs before every test
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = $this->mockTerminateResponse();

        error_reporting(E_ALL);
        ini_set('display_errors', '1');
    }

    protected function mockTerminateResponse(): MockObject
    {
        $mockResponse = $this->getMockBuilder(Response::class)
            ->onlyMethods(['terminate'])
            ->getMock();
        $mockResponse->expects($this->once())
            ->method('terminate')
            ->willReturn(null);

        return $mockResponse;
    }
}
