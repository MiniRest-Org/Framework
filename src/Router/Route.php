<?php

namespace MiniRestFramework\Router;

class Route
{
    private const METHOD_GET = 'GET';
    private const METHOD_POST = 'POST';
    private const METHOD_PUT = 'PUT';
    private const METHOD_PATCH = 'PATCH';
    private const METHOD_DELETE = 'DELETE';

    private static array $prefixStack = [];

    public static function get($uri, $action, $middleware = []): void
    {
        Router::add(self::METHOD_GET, $uri, $action, self::getRoutePrefix(), $middleware);
    }

    public static function post($uri, $action, $middleware = []): void
    {
        Router::add(self::METHOD_POST, $uri, $action, self::getRoutePrefix(), $middleware);
    }

    public static function put($uri, $action, $middleware = []): void
    {
        Router::add(self::METHOD_PUT, $uri, $action, self::getRoutePrefix(), $middleware);
    }

    public static function delete($uri, $action, $middleware = []): void
    {
        Router::add(self::METHOD_DELETE, $uri, $action, self::getRoutePrefix(), $middleware);
    }

    public static function patch($uri, $action, $middleware = []): void
    {
        Router::add(self::METHOD_PATCH, $uri, $action, self::getRoutePrefix(), $middleware);
    }

    public static function prefix($prefix): Route
    {
        // Adiciona o novo prefixo ao final da pilha
        $currentPrefix = end(self::$prefixStack);
        $newPrefix = $currentPrefix ? $currentPrefix . $prefix : $prefix;
        self::$prefixStack[] = $newPrefix;

        return new Route();
    }

    public function group($middlewares, $callback): void
    {
        $groupMiddlewares = is_array($middlewares) ? $middlewares : [$middlewares];
        Router::$groupMiddlewares = array_merge(Router::$groupMiddlewares, $groupMiddlewares);

        // Executa o callback do grupo
        $callback($this);

        // Remove o prefixo atual após processar o grupo
        array_pop(self::$prefixStack);
        Router::$groupMiddlewares = array_diff(Router::$groupMiddlewares, $groupMiddlewares);
    }

    private static function getRoutePrefix(): string
    {
        return end(self::$prefixStack) ?: '';
    }
}
