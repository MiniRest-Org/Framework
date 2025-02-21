<?php

namespace MiniRestFramework\Http\Request;

use MiniRestFramework\Http\Request\RequestValidation\RequestValidator;

class Request extends RequestValidator
{
    private array $get;
    private array $post;
    private array $files;
    private array $server;
    private array $requestData;
    private SanitizeService $sanitizeService;
    private array $headers;
    private array $routeParams;

    public function __construct(
        SanitizeService $sanitizeService,
        array $get = [],
        array $post = [],
        array $files = [],
        array $server = [],
        array $jsonData = null,
        array $headers = []
    )
    {
        $this->sanitizeService = $sanitizeService;
        $this->get = $this->sanitize($get ?: $_GET);
        $this->post = $this->sanitize($post ?: $_POST);
        $this->files = $files ?: $_FILES;
        $this->server = $server ?: $_SERVER;
        $this->requestData = $this->sanitize($jsonData ?? $this->getJsonData());
        $this->headers = $headers ?: $this->getAllHeaders();
        $this->routeParams = [];
    }

    public function set(string $key, $value): void
    {
        $this->routeParams[$key] = $this->sanitize($value);
    }

    public function setRequestParams(): void
    {
        $this->requestData = $this->sanitize($this->getJsonData() ?? []);
    }

    public function setRouteParams(array $matches): void
    {
        $this->routeParams = $matches;
    }

    public function getRouteParams(): array
    {
        return $this->routeParams;
    }

    public function __get(string $name)
    {
        return $this->findValue($name, $this->all());
    }

    public function get(string $key, $default = null)
    {
        return $this->findValue($key, $this->all(), $default);
    }

    public function post(string $key, $default = null)
    {
        return $this->findValue($key, ['post' => $this->post], $default);
    }

    public function files(string $key, $default = null)
    {
        return $this->findValue($key, ['files' => $this->files], $default);
    }

    public function json(string $key, $default = null)
    {
        return $this->findValue($key, ['json' => $this->requestData], $default);
    }

    public function all(): array
    {
        return [
            'get' => $this->sanitize($this->get),
            'post' => $this->sanitize($this->post),
            'files' => $this->files,
            'json' => $this->requestData,
            'routeParams' => $this->routeParams,
        ];
    }

    private function findValue(string $key, array $data, $default = null)
    {
        foreach (['get', 'post', 'files', 'json', 'routeParams'] as $source) {
            if (isset($data[$source][$key])) {
                return $data[$source][$key];
            }
        }
        return $default;
    }

    public function sanitize($data): array|string
    {
        return $this->sanitizeService->sanitize($data);
    }

    protected function getJsonData(): array
    {
        $jsonData = file_get_contents('php://input');
        return json_decode($jsonData, true) ?? [];
    }

    public function headers(string $headerName)
    {
        return $this->headers[$headerName] ?? null;
    }

    private function getAllHeaders(): array
    {
        $headers = [];
        foreach ($this->server as $key => $value) {
            if (str_starts_with($key, 'HTTP_')) {
                $headerName = str_replace('_', ' ', substr($key, 5));
                $headerName = ucwords(strtolower($headerName));
                $headerName = str_replace(' ', '-', $headerName);
                $headers[$headerName] = $value;
            }
        }
        return $headers;
    }

    public function getMethod(): string
    {
        return $this->server['REQUEST_METHOD'] ?? 'GET';
    }

    public function getUri(): string
    {
        return parse_url($this->server['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? '';
    }
}
