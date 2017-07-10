<?php

namespace frontend\controllers;

use Yii;

class UserController extends _UserController {

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionLogout() {
        Yii::$app->user->logout();
        return $this->goHome();
    }

}
