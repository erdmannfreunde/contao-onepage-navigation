<?php

$date = date('Y');

$header = <<<EOF
Contao Onepage Navigation for Contao Open Source CMS.

@copyright  Copyright (c) $date, Erdmann & Freunde
@author     Erdmann & Freunde <https://erdmann-freunde.de>
@license    MIT
@link       https://github.com/erdmannfreunde/contao-onepage-navigation
EOF;

$finder = (new \PhpCsFixer\Finder())
    ->in(__DIR__ . '/src');

return (new \PhpCsFixer\Config())
    ->setRules(
        [
            '@Symfony'       => true,
            'header_comment' => [
                'header' => $header
            ],
        ]
    )
    ->setFinder($finder)
    ->setUsingCache(false)
    ->setLineEnding("\r\n");