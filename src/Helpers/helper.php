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
    function view(string $template, array $variables = []): bool|string
    {
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
    function dd(...$vars): void
    {
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
        $config = ContainerManager::get('config');
        return $config->get($key, $default);
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

