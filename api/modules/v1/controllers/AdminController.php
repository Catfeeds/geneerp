<?php

namespace api\modules\v1\controllers;

use Yii;
use api\controllers\_ApiController;
use common\forms\AdminLoginForm;

class AdminController extends _ApiController {

    public $modelClass = 'common\models\Admin';

    public function actionLogin() {
        $model = new AdminLoginForm;
        $model->is_api = true;
        $model->setAttributes(Yii::$app->request->post());
        $result = $model->apiLogin();
        if ($result) {
            $this->successJson($result);
        } else {
            $this->errorModelJson($model);
        }
    }

}
