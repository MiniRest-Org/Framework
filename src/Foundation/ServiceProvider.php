<?php

namespace MiniRestFramework\Foundation;

class ServiceProvider
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function register()
    {
        // Cada provider terá sua lógica de registro
    }

    public function boot()
    {
        // Para lógica de inicialização pós-registro
    }
}
