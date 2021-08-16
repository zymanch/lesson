<?php
return [
    'bootstrap'  => ['debug'],
    'components' => [
        'mailer' => [
            'class'     => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => 'smtp.cloudevelops.com',
                'username'   => 'dmca_testing@legalporno.com',
                'password'   => 'mqFE01VbERCz',
                'port'       => '465',
                'encryption' => 'ssl',
            ],
        ],
    ],
    'modules'    => [
        'debug' => [
            'class'      => 'yii\debug\Module',
            'allowedIPs' => ['185.120.71.3'],
        ],
    ],
    'params'     => [
        'env'              => 'test',
        'debug'            => true,
        'client_secret'    => 'Sd9fgnFmg',
        'dmcaEmailAddress' => 'dmca_testing@legalporno.com',
        'dmcaEmailFrom'    => 'Legalporno Law Department',
        'defaultSender'    => 'Samuel DAUDA',
        'dmcaMail'         => [
            'login'               => 'dmca_testing@legalporno.com',
            'password'            => 'mqFE01VbERCz',
            'attachmentsDir'      => '/tmp/cache',
            'imapPath'            => '{mail1.cz2.cloudevelops.com:993/imap/ssl/novalidate-cert}INBOX',
            'dmcaNoticeIdPattern' => '/Notice #(\d{4,8})/',
        ],
    ],
];