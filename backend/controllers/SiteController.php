<?php

namespace backend\controllers;

use Yii;
use common\extensions\Util;
use backend\forms\LoginForm;

class SiteController extends _BackendController {

    public function actionTest() {
        
    }

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $this->layout = 'main-login';
            return $this->render('login', ['model' => $model]);
        }
    }

    public function actionLogout() {
        if (Yii::$app->request->isPost) {
            Yii::$app->user->logout();

            return $this->goHome();
        }
    }

    public function actionMyProfile() {
        $model = Yii::$app->user->identity;
        $model->setScenario('my-profile');
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $this->flashSuccess();
                return $this->refresh();
            } else {
                $this->flashError($model);
            }
        }

        return $this->render('my-profile', ['model' => $model]);
    }

    public function actionMyPassword() {
        $model = Yii::$app->user->identity;
        $model->setScenario('my-password');
        if ($model->load(Yii::$app->request->post())) {
            if ($model->updatePassword()) {
                $this->flashSuccess();
                return $this->refresh();
            } else {
                $this->flashError($model);
            }
        }

        return $this->render('my-password', ['model' => $model]);
    }

    public function actionClearCache() {
        $backend_runtime_dir = Yii::getAlias('@backend/runtime');
        $backend_runtime_array = Util::getDir($backend_runtime_dir);

        foreach ($backend_runtime_array as $dir) {
            Util::deleteDirAndFile($backend_runtime_dir . DIRECTORY_SEPARATOR . $dir);
        }

        $backend_dir = realpath(Yii::getAlias('@backend/web/assets'));
        $backend_array = Util::getDir($backend_dir);
        foreach ($backend_array as $dir) {
            Util::deleteDirAndFile($backend_dir . DIRECTORY_SEPARATOR . $dir);
        }

        $frontend_runtime_dir = Yii::getAlias('@frontend/runtime');
        $frontend_runtime_array = Util::getDir($frontend_runtime_dir);
        foreach ($frontend_runtime_array as $dir) {
            Util::deleteDirAndFile($frontend_runtime_dir . DIRECTORY_SEPARATOR . $dir);
        }

        $frontend_dir = realpath(Yii::getAlias('@frontend/web/assets'));
        $frontend_array = Util::getDir($frontend_dir);
        foreach ($frontend_array as $dir) {
            Util::deleteDirAndFile($frontend_dir . DIRECTORY_SEPARATOR . $dir);
        }
        $this->flashSuccess('清空缓存成功');
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionError() {
        return $this->render('error');
    }

}
