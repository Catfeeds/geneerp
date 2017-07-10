<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\Url;
use common\models\UserProfile;
use common\models\User;
use common\forms\ChangEmailValidateForm;
use common\forms\ChangMobileValidateForm;

class ProfileController extends _UserController {

    public function actionIndex() {
        $model = UserProfile::findOne(Yii::$app->user->getId());
        if (Yii::$app->request->isAjax) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate() && $model->save()) {
                    $this->ajaxSuccess();
                } else {
                    $this->returnAjaxError($model);
                }
            }
            $this->ajaxError();
        }

        $var['model'] = $model;

        return $this->render('index', $var);
    }

    public function actionSecurity() {
        return $this->render('security', User::getUserLevel());
    }

    public function actionChangePassword() {
        if (Yii::$app->request->isAjax) {
            $scenario = 'user-setting-password'; //用户密码若为空 不验证原密码
            if (Yii::$app->user->identity->c_login_password) {
                $scenario = 'user-change-password';
            }
            $this->updateLoginPassword($scenario);
        }

        return $this->render('change-password');
    }

    public function actionChangeEmail() {
        if (Yii::$app->request->isAjax) {
            $this->validatePassword('change-email-validate');
        }

        return $this->render('change-email');
    }

    public function actionChangeEmailValidate() {
        if (!isset(Yii::$app->session['change-email-validate'])) {
            return $this->redirect(Url::to(['security']));
        }

        if (Yii::$app->request->isAjax) {
            $this->updateEmail();
        }

        return $this->render('change-email-validate');
    }

    public function actionChangeMobile() {
        if (Yii::$app->request->isAjax) {
            $this->validatePassword('change-mobile-validate');
        }

        return $this->render('change-mobile');
    }

    public function actionChangeMobileValidate() {
        if (!isset(Yii::$app->session['change-mobile-validate'])) {
            return $this->redirect(Url::to(['security']));
        }

        if (Yii::$app->request->isAjax) {
            $this->updateMobile();
        }

        return $this->render('change-mobile-validate');
    }

    public function actionChangePayPassword() {
        if (empty(Yii::$app->user->identity->c_login_password)) {
            return $this->redirect(Url::to(['security']));
        }

        if (Yii::$app->request->isAjax) {
            $scenario = 'user-setting-pay-password'; //用户支付密码若为空 不验证原支付密码 但要验证原登录密码
            if (Yii::$app->user->identity->c_pay_password) {
                $scenario = 'user-change-pay-password';
            }
            $this->updatePayPassword($scenario);
        }

        return $this->render('change-pay-password');
    }

    /**
     * 关闭支付密码
     * @return type
     */
    public function actionClosePayPassword() {
        if (empty(Yii::$app->user->identity->c_pay_password) || empty(Yii::$app->user->identity->c_login_password)) {
            return $this->redirect(Url::to(['security']));
        }

        if (Yii::$app->request->isAjax) {
            $model = Yii::$app->user->identity;
            $model->setScenario('user-validate-password');
            if ($model->load(Yii::$app->request->post())) {
                if ($model->closePayPassword()) {
                    $this->ajaxSuccess(null, 2, Url::to(['security']));
                } else {
                    $this->returnAjaxError($model);
                }
            } else {
                $this->ajaxError();
            }
        }

        return $this->render('close-pay-password');
    }

    /**
     * 验证登录密码
     * @param type $url
     */
    private function validatePassword($url) {
        $model = Yii::$app->user->identity;
        $model->setScenario('user-validate-password');
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                Yii::$app->session[$url] = true;
                $this->ajaxSuccess(null, 5, Url::to([$url]));
            } else {
                $this->returnAjaxError($model);
            }
        } else {
            $this->ajaxError();
        }
    }

    /**
     * 更新登录密码
     * @param type $scenario
     */
    private function updateLoginPassword($scenario) {
        $model = Yii::$app->user->identity;
        $model->setScenario($scenario);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->updateLoginPassword()) {
                $this->ajaxSuccess(null, 2, Url::to(['security']));
            } else {
                $this->returnAjaxError($model);
            }
        } else {
            $this->ajaxError();
        }
    }

    /**
     * 更新支付密码
     * @param type $scenario
     */
    private function updatePayPassword($scenario) {
        $model = Yii::$app->user->identity;
        $model->setScenario($scenario);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->updatePayPassword()) {
                $this->ajaxSuccess(null, 2, Url::to(['security']));
            } else {
                $this->returnAjaxError($model);
            }
        } else {
            $this->ajaxError();
        }
    }

    /**
     * 更新邮箱
     * @param type $type
     */
    private function updateEmail() {
        $model = new ChangEmailValidateForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->changeEmail()) {
                $this->ajaxSuccess(null, 2, Url::to(['security']));
            } else {
                $this->returnAjaxError($model);
            }
        } else {
            $this->ajaxError();
        }
    }

    /**
     * 更新手机号
     */
    private function updateMobile() {
        $model = new ChangMobileValidateForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->changeMobile()) {
                $this->ajaxSuccess(null, 2, Url::to(['security']));
            } else {
                $this->returnAjaxError($model);
            }
        } else {
            $this->ajaxError();
        }
    }

}
