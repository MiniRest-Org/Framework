<?php

namespace MiniRestFramework\Http\Request;

use MiniRestFramework\Http\Request\RequestValidation\RequestValidator;

class Request extends RequestValidator
{
    private array $requestData = [];
    private array $routeParams = [];

    public function __construct()
    {
        $this->setRequestParams();
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
        $data = $this->all();
        return $this->findValue($name, $data);
    }

    public function get(string $key, $default = null)
    {
        $data = $this->all();
        return $this->findValue($key, $data, $default);
    }

    public function post(string $key, $default = null)
    {
        return $this->findValue($key, ['post' => $_POST], $default);
    }

    public function files(string $key, $default = null)
    {
        return $this->findValue($key, ['files' => $_FILES], $default);
    }

    public function json(string $key, $default = null)
    {
        return $this->findValue($key, ['json' => $this->requestData], $default);
    }

    public function all(): array
    {
        return [
            'get' => $this->sanitize($_GET),
            'post' => $this->sanitize($_POST),
            'files' => $_FILES,
            'json' => $this->requestData,
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

    private function sanitize($data): array|string
    {
        if (is_array($data)) {
            return array_map([$this, 'sanitize'], $data);
        }

        return htmlspecialchars((string) $data, ENT_QUOTES, 'UTF-8');
    }

    protected function getJsonData(): array
    {
        $jsonData = file_get_contents('php://input');
        return json_decode($jsonData, true) ?? [];
    }

    public function headers(string $headerName)
    {
        $headers = $this->getAllHeaders();
        return $headers[$headerName] ?? null;
    }

    private function getAllHeaders(): array
    {
        $headers = [];
        foreach ($_SERVER as $key => $value) {
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
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getUri(): string
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '';
    }
}
