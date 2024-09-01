<?php

namespace MiniRestFramework\config;

class Config
{
    protected array $config = [];
    private string $configPath;

    public function __construct(string $configPath = null)
    {
        $this->configPath = $configPath ?? dirname(__DIR__, env('ROOT_PATH_LEVEL', 5)) . '/config/';
        $this->loadConfigurations();    }

    /**
     * Carrega todos os arquivos de configuração da pasta config/.
     */
    protected function loadConfigurations(): void
    {
        $configFiles = glob($this->configPath . '*.php');

        foreach ($configFiles as $file) {
            $key = basename($file, '.php');
            $this->config[$key] = require $file;
        }
    }

    /**
     * Obtém um valor de configuração usando notação de ponto.
     */
    public function get(string $key, $default = null)
    {
        $keys = explode('.', $key);
        $value = $this->config;

        foreach ($keys as $segment) {
            if (array_key_exists($segment, $value)) {
                $value = $value[$segment];
            } else {
                return $default;
            }
        }

        return $value;
    }

    /**
     * Define um valor de configuração.
     */
    public function set(string $key, $value)
    {
        $keys = explode('.', $key);
        $config = &$this->config;

        foreach ($keys as $segment) {
            if (!isset($config[$segment])) {
                $config[$segment] = [];
            }
            $config = &$config[$segment];
        }

        $config = $value;
    }
}