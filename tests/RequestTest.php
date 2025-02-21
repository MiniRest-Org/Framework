<?php

namespace MiniRestFramework\Tests;

use MiniRestFramework\Http\Request\Request;
use MiniRestFramework\Http\Request\SanitizeService;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testCanRetrieveGetParam()
    {
        $sanitizeService = $this->createMock(SanitizeService::class);
        $sanitizeService->method('sanitize')->willReturnArgument(0);

        $request = new Request($sanitizeService, ['name' => 'John']);
        $this->assertEquals('John', $request->get('name'));
    }

    public function testCanRetrievePostParam()
    {
        $sanitizeService = $this->createMock(SanitizeService::class);
        $sanitizeService->method('sanitize')->willReturnArgument(0);

        $request = new Request($sanitizeService, [], ['email' => 'john@example.com']);
        $this->assertEquals('john@example.com', $request->post('email'));
    }
}