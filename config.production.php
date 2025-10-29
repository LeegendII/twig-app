<?php
// Production configuration settings

return [
    'twig' => [
        'cache' => __DIR__ . '/var/cache/twig',
        'debug' => false,
        'auto_reload' => false,
    ],
    'display_errors' => 0,
    'error_reporting' => E_ALL & ~E_DEPRECATED & ~E_STRICT,
];