<?php

use MiniRestFramework\DI\ContainerManager;

if (!function_exists("view")) {
    /**
     * Renderiza um template com variáveis.
     *
     * @param string $template O nome do template.
     * @param array $variables Variáveis para injetar no template.
     * @return bool|string O conteúdo renderizado do template.
     * @throws Exception Se o arquivo de template não for encontrado.
     */
    function view($template, $variables = []) {
        $templateEngine = ContainerManager::get('templateEngine');
        return $templateEngine->render($template, $variables);
    }
}

if (!function_exists("dd")) {
    /**
     * Dump and Die - Output the given variables and terminate the script.
     *
     * @param mixed ...$vars Variables to dump
     * @return void
     */
    function dd(...$vars) {
        foreach ($vars as $var) {
            var_dump($var);
        }
        die();
    }

}

if (!function_exists("dump")) {
    /**
     * Dump - Output the given variables without terminating the script.
     *
     * @param mixed ...$vars Variables to dump
     * @return void
     */
    function dump(...$vars) {
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
     * @param mixed $default Valor padrão a ser retornado se a configuração não for encontrada.
     * @return mixed
     */
    function config(string $key, $default = null)
    {
        $config = ContainerManager::get('config');
        return $config->get($key, $default);
    }
}
