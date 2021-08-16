<?php
return [
    'bootstrap'  => ['debug', 'gii'],
    'modules'    => [
        'debug' => [
            'class' => 'yii\debug\Module',
        ],
        'gii'   => [
            'class'      => 'yii\gii\Module',
            'allowedIPs' => ['127.0.0.1', '::1']  //allowing ip's
        ],
    ],
    'params'     => [
        'env'              => 'dev',
        'debug'            => true,
    ]
];