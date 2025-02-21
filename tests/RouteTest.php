<?php

namespace MiniRestFramework\Tests;

use MiniRestFramework\Router\Route;
use MiniRestFramework\Router\Router;
use PHPUnit\Framework\TestCase;


class RouteTest extends TestCase
{
    public function setUp(): void
    {
        // Aqui você pode limpar as rotas ou resetar o estado do Router se necessário.
        Router::clearRoutes();  // Supondo que você tenha um método para limpar as rotas.
    }

    public function testGetRouteIsAddedCorrectly()
    {
        // Definindo uma rota GET
        Route::get('/test', 'TestController@index');

        // Verifica se a rota foi adicionada corretamente
        $routes = Router::getRoutes();

        $expectedRouteStructure = [
            'method'      => 'GET',
            'route'       => '#^/test$#',
            'action'      => 'TestController@index',
            'middlewares' => []
        ];

        $this->assertEquals($expectedRouteStructure, $routes[0]);
    }


    public function testPostRouteIsAddedCorrectly()
    {
        // Definindo uma rota POST
        Route::post('/submit', 'SubmitController@store');

        // Verifica se a rota foi adicionada corretamente
        $routes = Router::getRoutes();

        $expectedRouteStructure = [
            'method'      => 'POST',
            'route'       => '#^/submit$#',
            'action'      => 'SubmitController@store',
            'middlewares' => []
        ];

        $this->assertEquals($expectedRouteStructure, $routes[0]);
    }

    public function testPutRouteIsAddedCorrectly()
    {
        // Definindo uma rota POST
        Route::put('/submit', 'SubmitController@store');

        // Verifica se a rota foi adicionada corretamente
        $routes = Router::getRoutes();

        $expectedRouteStructure = [
            'method'      => 'PUT',
            'route'       => '#^/submit$#',
            'action'      => 'SubmitController@store',
            'middlewares' => []
        ];

        $this->assertEquals($expectedRouteStructure, $routes[0]);
    }

    public function testPatchRouteIsAddedCorrectly()
    {
        // Definindo uma rota POST
        Route::patch('/submit', 'SubmitController@store');

        // Verifica se a rota foi adicionada corretamente
        $routes = Router::getRoutes();

        $expectedRouteStructure = [
            'method'      => 'PATCH',
            'route'       => '#^/submit$#',
            'action'      => 'SubmitController@store',
            'middlewares' => []
        ];

        $this->assertEquals($expectedRouteStructure, $routes[0]);
    }

    public function testDeleteRouteIsAddedCorrectly()
    {
        // Definindo uma rota POST
        Route::delete('/submit', 'SubmitController@store');

        // Verifica se a rota foi adicionada corretamente
        $routes = Router::getRoutes();

        $expectedRouteStructure = [
            'method'      => 'DELETE',
            'route'       => '#^/submit$#',
            'action'      => 'SubmitController@store',
            'middlewares' => []
        ];

        $this->assertEquals($expectedRouteStructure, $routes[0]);
    }

    public function testRouteWithMiddleware()
    {
        // Definindo uma rota com middleware
        Route::get('/admin', 'AdminController@index', ['auth']);

        // Verifica se a rota foi adicionada corretamente
        $routes = Router::getRoutes();

        $expectedRouteStructure = [
            'method'      => 'GET',
            'route'       => '#^/admin$#',
            'action'      => 'AdminController@index',
            'middlewares' => ['auth']
        ];

        $this->assertEquals($expectedRouteStructure, $routes[0]);
    }

    public function testRouteWithPrefix()
    {
        // Adicionando um prefixo para o grupo de rotas
        Route::prefix('/api')->group([], function() {
            Route::get('/test', 'ApiController@test');
        });

        // Verifica se a rota com o prefixo foi adicionada corretamente
        $routes = Router::getRoutes();

        $expectedRouteStructure = [
            'method'      => 'GET',
            'route'       => '#^/api/test$#',
            'action'      => 'ApiController@test',
            'middlewares' => []
        ];

        $this->assertEquals($expectedRouteStructure, $routes[0]);
    }
}