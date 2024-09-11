<?php

return [
    'if' => [
        'pattern' => '/@if\s*\((.*s?)\)\s*/',
        'callback' => function($expression) {
            return "<?php if ($expression): ?>";
        }
    ],
    'elseif' => [
        'pattern' => '/@elseif\s*\((.*s?)\)\s*/',
        'callback' => function($expression) {
            return "<?php elseif ($expression): ?>";
        }
    ],
    'else' => [
        'pattern' => '/@else\s*/',
        'callback' => function() {
            return "<?php else: ?>";
        }
    ],
    'endif' => [
        'pattern' => '/@endif\s*/sU',
        'callback' => function() {
            return "<?php endif; ?>";
        }
    ],
    'foreach' => [
        'pattern' => '/@foreach\s*\((.*s?)\)\s*/',
        'callback' => function($expression) {
            return "<?php foreach ($expression): ?>";
        }
    ],
    'endforeach' => [
        'pattern' => '/@endforeach\s*/',
        'callback' => function() {
            return "<?php endforeach; ?>";
        }
    ],
    'dd' => [
        'pattern' => '/@dd\s*\((.*s?)\)\s*/',
        'callback' => function($expression) {
            return "<?php dd($expression); ?>";
        }
    ],
    'dump' => [
        'pattern' => '/@dump\s*\((.*s?)\)\s*/',
        'callback' => function($expression) {
            return "<?php dump($expression); ?>";
        }
    ],

    'extends' => [
        'pattern' => '/@extends\s*\(\'(.*)\'\)\s*/',
        'callback' => function($expression) {
            return "<?php \$this->setLayout('$expression'); ?>";
        }
    ],
    'yield' => [
        'pattern' => '/@yield\s*\(\'(.*)\'\)\s*/',
        'callback' => function($expression) {
            return "<?php echo \$this->yieldSection('$expression'); ?>";
        }
    ],
    'section' => [
        'pattern' => '/@section\s*\(\'(.*)\'\)\s*/',
        'callback' => function($expression) {
            return "<?php \$this->startSection('$expression'); ?>";
        }
    ],
    'endsection' => [
        'pattern' => '/@endsection\s*/',
        'callback' => function() {
            return "<?php \$this->endSection(); ?>";
        }
    ],

];
