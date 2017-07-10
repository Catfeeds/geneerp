<?php

$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/params.php')
);

return [
    'id' => 'app-ssm',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_jjcms_user_csrf',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_jjcms_user_identity', 'httpOnly' => true],
            'loginUrl' => ['site/login'],
        ],
        'session' => [
            'name' => '_jjcms_user_session',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    //'urlManager' => require(__DIR__ . '/rules.php'),
    ],
    'params' => $params,
];
