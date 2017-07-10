<?php

$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/params.php')
);

$config = [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_jjcms_admin_csrf',
        ],
        'user' => [
            'identityClass' => 'backend\models\Admin',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_jjcms_admin_identity', 'httpOnly' => true],
            'loginUrl' => ['site/login'],
        ],
        'session' => [
            'name' => '_jjcms_admin_session',
        ],
    ],
    'params' => $params,
];
return $config;
