<?php

use MiniRestFramework\DI\Container;
use MiniRestFramework\Support\Facades\{App, Config, DB, View};
use MiniRestFramework\Foundation\Application;

if (!function_exists("view")) {
    /**
     * Renderiza um template com variáveis.
     *
     * @param string $template O nome do template.
     * @param array $variables Variáveis para injetar no template.
     * @return bool|string O conteúdo renderizado do template.
     * @throws Exception Se o arquivo de template não for encontrado.
     */
    function view(string $template, array $variables = []): bool|string
    {
        return View::render($template, $variables);
    }
}


if (!function_exists('app')) {
    /**
     * Obtém uma instância do container ou resolve um serviço.
     *
     * @param string|null $abstract Nome da classe ou interface para resolver.
     * @return Container|mixed
     * @throws Exception
     */
    function app(string $abstract = null): mixed
    {

        if ($abstract !== null) {
            return Application::getContainer()->get($abstract);
        }

        // Obtém a instância do container global
        return Application::getContainer();

    }
}

if (!function_exists('class_basename')) {
    /**
     * Get the class "basename" of the given object / class.
     *
     * @param object|string $class
     * @return string
     */
    function class_basename(object|string $class): string
    {
        $class = is_object($class) ? get_class($class) : $class;

        return basename(str_replace('\\', '/', $class));
    }
}


if (!function_exists("dd")) {
    /**
     * Dump and Die - Output the given variables and terminate the script.
     *
     * @param mixed ...$vars Variables to dump
     * @return void
     */
    function dd(...$vars): void
    {
        foreach ($vars as $var) {
            var_dump($var);
        }
        die();
    }

}

if (! function_exists('storage_path')) {
    /**
     * Get the path to the storage folder.
     *
     * @param string $path
     * @return string
     * @throws Exception
     */
    function storage_path(string $path = ''): string
    {
        return app()->storagePath($path);
    }
}

if (!function_exists("dump")) {
    /**
     * Dump - Output the given variables without terminating the script.
     *
     * @param mixed ...$vars Variables to dump
     * @return void
     */
    function dump(...$vars): void
    {
        foreach ($vars as $var) {
            var_dump($var);
        }
    }
}

if (!function_exists("config")) {
    /**
     * Obtém o valor de configuração usando notação de ponto.
     *
     * @param string $key A chave de configuração no formato de notação de ponto (ex. 'app.name').
     * @param mixed|null $default Valor padrão a ser retornado se a configuração não for encontrada.
     * @return mixed
     */
    function config(string $key, mixed $default = null): mixed
    {
        return Config::get($key, $default);
    }
}

if (!function_exists('removeLastCharacter')) {
    /**
     * Remove o último caractere específico de uma string, se presente no final.
     *
     * @param string $string A string original.
     * @param string $charToRemove O caractere a ser removido.
     * @return string A string sem o último caractere específico.
     */
    function removeLastCharacter(string $string, string $charToRemove): string
    {
        // Verifica se a string termina com o caractere especificado
        if (str_ends_with($string, $charToRemove)) {
            // Remove o caractere do final da string
            return substr($string, 0, -strlen($charToRemove));
        }

        return $string;
    }
}

