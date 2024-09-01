<?php

namespace MiniRestFramework\View;

use Exception;

class TemplateEngine {
    protected array $variables = [];
    protected array $directives = [];
    private string $templateDirectory;

    protected ?string $layout = null;
    protected array $sections = [];
    protected ?string $currentSection = null;

    public function __construct($templateDirectory = 'views') {
        $this->templateDirectory = rtrim($templateDirectory, '/') . '/';
        $this->loadDirectives();
    }

    protected function loadDirectives(): void
    {
        $directivesConfig = require __DIR__ . '/../config/directives.php';

        foreach ($directivesConfig as $name => $config) {
            $this->addDirective($name, $config['callback'], $config['pattern']);
        }
    }

    public function assign($key, $value): void
    {
        $this->variables[$key] = $value;
    }

    public function addDirective($name, $callback, $pattern): void
    {
        $this->directives[$name] = [
            'callback' => $callback,
            'pattern' => $pattern,
        ];
    }

    /**
     * Renderiza um template com variáveis.
     *
     * @param string $template O nome do template.
     * @param array $variables Variáveis para injetar no template.
     * @return bool|string O conteúdo renderizado do template.
     * @throws Exception Se o arquivo de template não for encontrado.
     */
    public function render(string $template, array $variables = []): bool|string
    {

        $template = str_replace('.', '/', $template);

        $filePath = $this->templateDirectory . $template . '.view.php';
        if (!file_exists($filePath)) {
            throw new Exception("Template file not found: $filePath");
        }

        $content = file_get_contents($filePath);
        $content = $this->processDirectives($content);
        extract(array_merge($this->variables, $variables));
        ob_start();
        eval('?>' . $content);

        if ($this->layout !== null && $template !== str_replace('.', '/', $this->layout)) {
            return $this->render($this->layout, $variables);
        }

        return ob_get_clean();
    }

    /**
     * Processa diretivas no conteúdo do template.
     *
     * @param string $content O conteúdo do template.
     * @return string O conteúdo do template com as diretivas processadas.
     */
    protected function processDirectives(string $content): string
    {
        // Substituições para variáveis Blade {{ $variavel }}
        $content = preg_replace_callback(
            '/{{\s*(\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\s*}}/',
            function ($matches) {
                return '<?php echo htmlspecialchars(' . $matches[1] . ', ENT_QUOTES, \'UTF-8\'); ?>';
            },
            $content
        );

        // Substituições para estruturas de controle Blade
        foreach ($this->directives as $name => $config) {
            $content = preg_replace_callback(
                $config['pattern'],
                function ($matches) use ($config) {
                    $expression = isset($matches[1]) ? trim($matches[1]) : '';
                    return call_user_func($config['callback'], $expression);
                },
                $content
            );
        }

        return $content;
    }


    public function setLayout(string $layout): void {
        $this->layout = $layout;
    }

    public function startSection(string $name): void {
        $this->currentSection = $name;
        ob_start();
    }

    public function endSection(): void {
        if ($this->currentSection !== null) {
            $this->sections[$this->currentSection] = ob_get_clean();
            $this->currentSection = null;
        }
    }

    public function yieldSection(string $name): ?string {
        return $this->sections[$name] ?? null;
    }
}
