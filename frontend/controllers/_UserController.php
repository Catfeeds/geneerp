<?php

namespace frontend\controllers;

use yii\filters\AccessControl;

class _UserController extends _FrontendController {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [], //当前rule将会针对这里设置的actions起作用，如果actions不设置，默认就是当前控制器的所有操作
                        'allow' => true, //设置actions的操作是允许访问还是拒绝访问
                        'roles' => ['@'] //@ 当前规则针对认证过的用户 ? 所有用户均可访问
                    ],
                ],
            ],
        ];
    }

    public function init() {
        parent::init();
        $this->title = '用户中心';
        $this->setLayout(self::UCENTER_LAYOUT);
    }

}
