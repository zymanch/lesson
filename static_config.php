<?php

return [
    'id' => 'lesson',
    'language' => 'ru-RU',
    'basePath' => __DIR__ . '/src',
    'vendorPath' => __DIR__ . '/vendor',
    'runtimePath' => __DIR__ . '/src/runtime',
    'controllerNamespace' => 'controllers',
    'defaultRoute' => 'lesson/index',
    'bootstrap' => ['debug'],
    'modules' => [
        'debug' => [
            'class' => 'yii\debug\Module',
            'allowedIPs' => [
                '127.0.0.1',
            ],
        ],
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],

    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'cookieValidationKey' => 'bhjasd_ji75AS7jAs81',
        ],
        'user' => [
            'identityClass' => 'models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'loginUrl' => ['profile/login'],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'AP_SESSID',
        ],
        'assetManager' => [
            'hashCallback' => function ($path) {
                $path = (is_file($path) ? dirname($path) : $path);

                return sprintf('%x', crc32($path . Yii::getVersion()));
            },
        ],
        'errorHandler' => [
            'errorAction' => 'error/index',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<id:\w+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=' . $secure['mysql']['mysqlcluster']['hostname'] . ';dbname=lesson',
            'username' => $secure['mysql']['mysqlcluster']['username'],
            'password' => $secure['mysql']['mysqlcluster']['password'],
            'charset' => 'utf8',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 3600,
            'schemaCache' => 'cache',
        ],
        'log' => [
            'flushInterval' => 1,
            'traceLevel' => 3,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'exportInterval' => 1,
                    'logVars' => [],
                ],
            ],
        ],
    ],
    'params' => [
        'user_password' => 'qwe123'
    ],
];