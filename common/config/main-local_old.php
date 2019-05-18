<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=metragYiiNew',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
            //'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                /*'host' => 'localhost',
                'username' => 'username',
                'password' => 'password',*/
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],

    ],
];
