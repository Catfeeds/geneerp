<?php

return [
    'bootstrap' => ['log'],
    'language' => 'zh-CN',
    'timeZone' => 'PRC',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info'],
                    'logFile' => '@runtime/logs/' . date('Ymd') . '.log',
                ],
            ],
        ],
        //redis参考 http://www.yiichina.com/tutorial/550
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => '127.0.0.1',
            'port' => 6379,
            'database' => 0,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'redisCache' => [
            'class' => 'yii\redis\Cache',
        ],
        'sessionCache' => [
            'class' => 'yii\redis\Session',
        ],
        'db' => require(__DIR__ . '/db.php'),
        'mailer' => require(__DIR__ . '/email.php'),
        'i18n' => [
            'translations' => [
                'common' => [
                    'class' => 'yii\i18n\PhpMessageSource', //使用php文件保存信息
                    'basePath' => '@common/messages', //php文件保存位置
                    'fileMap' => [
                        'common' => 'common.php',
                    ],
                ],
            ],
        ],
    ],
];
