<?php

$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/params.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'
        ],
        'v2' => [
            'basePath' => '@app/modules/v2',
            'class' => 'api\modules\v2\Module'
        ]
    ],
    'components' => [
        'errorHandler' => [
            'class' => 'api\component\exception\ErrorHandler',
        ],
        'user' => [
            'identityClass' => 'common\models\Admin',
            'enableAutoLogin' => true,
            'enableSession' => false,
            'loginUrl' => null
        ],
        'request' => [
            'class' => 'yii\web\Request',
            'enableCookieValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'response' => [
            'class' => 'api\component\ApiResponse',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                $response->format = yii\web\Response::FORMAT_JSON;
                $response->data = [
                    'success' => $response->api_success,
                    'status' => $response->statusCode,
                    'message' => $response->api_message,
                    'data' => $response->data,
                ];
            },
                ],
                'urlManager' => require(__DIR__ . '/rules.php'),
            ],
            'params' => $params,
        ];
        