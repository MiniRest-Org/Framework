<?php

namespace MiniRestFramework\Http\Request;

class SanitizeService
{
    /**
     * Sanitiza os dados recebidos para evitar XSS ou injeção de código.
     *
     * @param mixed $data Dados a serem sanitizados.
     * @return array|string Dados sanitizados.
     */
    public function sanitize(mixed $data): array|string
    {
        if (is_array($data)) {
            return array_map([$this, 'sanitize'], $data); // Recursivamente sanitiza os itens do array.
        }

        // Retorna os dados sanitizados para evitar XSS (se for uma string)
        return htmlspecialchars((string) $data, ENT_QUOTES, 'UTF-8');
    }
}