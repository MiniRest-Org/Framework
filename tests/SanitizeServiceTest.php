<?php

namespace MiniRestFramework\Tests;

use MiniRestFramework\Http\Request\SanitizeService;
use PHPUnit\Framework\TestCase;

class SanitizeServiceTest extends TestCase
{
    private SanitizeService $sanitizeService;

    protected function setUp(): void
    {
        $this->sanitizeService = new SanitizeService();
    }

    public function testSanitizeString()
    {
        $input = "<script>alert('XSS');</script>";
        $expected = "&lt;script&gt;alert(&#039;XSS&#039;);&lt;/script&gt;";

        $this->assertEquals($expected, $this->sanitizeService->sanitize($input));
    }

    public function testSanitizeArray()
    {
        $input = [
            "<script>alert('XSS');</script>",
            "Hello <b>World</b>"
        ];

        $expected = [
            "&lt;script&gt;alert(&#039;XSS&#039;);&lt;/script&gt;",
            "Hello &lt;b&gt;World&lt;/b&gt;"
        ];

        $this->assertEquals($expected, $this->sanitizeService->sanitize($input));
    }

    public function testSanitizeEmpty()
    {
        $input = "";
        $this->assertEquals("", $this->sanitizeService->sanitize($input));
    }
}