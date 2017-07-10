<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\Url;
use common\messages\Common;
use common\extensions\Captcha;
use common\models\User;
use common\models\NotityTemplate;
use common\forms\RegisterEmailForm;
use common\forms\RegisterMobileForm;
use common\forms\FindPasswordForm;
use common\forms\FindPasswordValidateForm;
use common\forms\FindPasswordResetForm;
use common\forms\LoginForm;
use common\forms\LoginSmsForm;

class SiteController extends _FrontendController {

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionError() {
        $this->setLayout(self::SIMPLE_LAYOUT);

        return $this->render('error');
    }

    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        if (Yii::$app->request->isAjax) {
            $model = new LoginForm();
            if ($model->load(Yii::$app->request->post())) {
                if ($model->login()) {
                    $this->ajaxSuccess(null, 5, Url::to(['user/index']));
                } else {
                    $this->returnAjaxError($model);
                }
            }
        }
        $this->setLayout(self::SIMPLE_LAYOUT);
        $this->title = '用户登录';

        return $this->render('login');
    }

    public function actionLoginSms() {
        if (Yii::$app->request->isAjax) {
            $model = new LoginSmsForm();
            if ($model->load(Yii::$app->request->post())) {
                if ($model->login()) {
                    $this->ajaxSuccess(null, 6);
                } else {
                    $this->returnAjaxError($model);
                }
            }
        }
    }

    public function actionRegisterMobile() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if (Yii::$app->request->isAjax) {
            $model = new RegisterMobileForm();
            if ($model->load(Yii::$app->request->post())) {
                $model->create_type = User::CREATE_PC;
                $user = $model->register(true);
                if ($user && Yii::$app->user->login($user)) {
                    $this->ajaxSuccess(null, 5, Url::to(['register-success']));
                } else {
                    $this->returnAjaxError($model);
                }
            }
        }
        $this->setLayout(self::SIMPLE_LAYOUT);
        $this->title = '手机注册';

        return $this->render('register-mobile');
    }

    public function actionRegisterEmail() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        if (Yii::$app->request->isAjax) {
            $model = new RegisterEmailForm();
            if ($model->load(Yii::$app->request->post())) {
                $model->create_type = User::CREATE_PC;
                $user = $model->register();
                if ($user && Yii::$app->user->login($user)) {
                    $this->ajaxSuccess(null, 5, Url::to(['register-success']));
                } else {
                    $this->returnAjaxError($model);
                }
            }
        }
        $this->setLayout(self::SIMPLE_LAYOUT);
        $this->title = '邮箱注册';

        return $this->render('register-email');
    }

    public function actionRegisterSuccess() {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->setLayout(self::SIMPLE_LAYOUT);
        $this->title = '注册成功';

        return $this->render('register-success');
    }

    public function actionFindPassword() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        if (Yii::$app->request->isAjax) {
            $model = new FindPasswordForm();
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate() && isset(Yii::$app->session['find_password_user_id'])) {
                    $this->ajaxSuccess(null, 5, Url::to(['find-password-validate']));
                } else {
                    $this->returnAjaxError($model);
                }
            }
        }

        $this->setLayout(self::SIMPLE_LAYOUT);
        $this->title = '忘记密码';

        return $this->render('find-password');
    }

    public function actionFindPasswordValidate() {
        if (!isset(Yii::$app->session['find_password_user_id'])) {
            return $this->goHome();
        }

        if (Yii::$app->request->isAjax) {
            $model = new FindPasswordValidateForm();
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate() && isset(Yii::$app->session['find_password_validate'])) {
                    $this->ajaxSuccess(null, 5, Url::to(['find-password-reset']));
                } else {
                    $this->returnAjaxError($model);
                }
            }
        }

        $model = User::findOne(Yii::$app->session['find_password_user_id']);
        if ($model) {
            $this->setLayout(self::SIMPLE_LAYOUT);
            $this->title = '找回密码';
            $var['model'] = $model;
            $var['type'] = Yii::$app->request->get('type');

            return $this->render('find-password-validate', $var);
        } else {
            return $this->goHome();
        }
    }

    public function actionFindPasswordReset() {
        if (!isset(Yii::$app->session['find_password_user_id']) || !isset(Yii::$app->session['find_password_validate'])) {
            return $this->goHome();
        }

        if (Yii::$app->request->isAjax) {
            $model = new FindPasswordResetForm();
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    $this->ajaxSuccess(null, 5, Url::to(['find-password-success']));
                } else {
                    $this->returnAjaxError($model);
                }
            }
        }

        $this->setLayout(self::SIMPLE_LAYOUT);
        $this->title = '找回密码';

        return $this->render('find-password-reset');
    }

    public function actionFindPasswordSuccess() {
        $this->setLayout(self::SIMPLE_LAYOUT);
        $this->title = '找回密码';

        return $this->render('find-password-success');
    }

    public function actionSmsCode() {
        if (Yii::$app->request->isAjax) {
            $mobile = Yii::$app->request->post('mobile');
            $captcha = Yii::$app->request->post('captcha');
            $code_type = Yii::$app->request->post('type');
            if (!Captcha::checkCaptcha($captcha)) {
                $this->ajaxError(Yii::t('common', Common::CAPTCHA_CHECK_FAIL));
            }
            $result = NotityTemplate::sendSmsCode($code_type, $mobile);
            if ($result === true) {
                $this->ajaxSuccess();
            } else {
                $this->ajaxError($result);
            }
        }
        $this->ajaxError();
    }

    public function actionEmailCode() {
        if (Yii::$app->request->isAjax) {
            $email = Yii::$app->request->post('email');
            $captcha = Yii::$app->request->post('captcha');
            $code_type = Yii::$app->request->post('type');
            if (!Captcha::checkCaptcha($captcha)) {
                $this->ajaxError(Yii::t('common', Common::CAPTCHA_CHECK_FAIL));
            }
            $result = NotityTemplate::sendEmailCode($code_type, $email);
            if ($result === true) {
                $this->ajaxSuccess();
            } else {
                $this->ajaxError($result);
            }
        }
        $this->ajaxError();
    }

}
