<?php

Uni::setAlias('@tests', dirname(__DIR__) . '/tests');

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

return [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'generator'],
    'controllerNamespace' => 'app\commands',
    'modules' => [
        'generator' => 'uni\generator\Module',
    ],
    'components' => [
        'cache' => [
            'class' => 'uni\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'uni\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
];
