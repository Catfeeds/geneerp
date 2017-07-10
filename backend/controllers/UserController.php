<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\UserAcount;
use backend\forms\UserAcountForm;
use backend\forms\UserSearch;

class UserController extends _BackendController {

    public function actionIndex() {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }

    public function actionCreate() {
        $model = new User();
        $model->setScenario('create');
        if (Yii::$app->request->isPost) {
            if ($this->commonCreate($model)) {
                return $this->refresh();
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->setScenario('update');
        if (Yii::$app->request->isPost) {
            if ($this->commonUpdate($model)) {
                return $this->refresh();
            }
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionAmount($id) {
        $model = $this->findUserAcountModel($id);
        $user_acount_model = new UserAcountForm();
        if ($user_acount_model->load(Yii::$app->request->post())) {
            $result = $user_acount_model->amount();
            if ($result === true) {
                $this->flashSuccess();
                return $this->refresh();
            } else {
                $this->flashError(null, $result);
            }
        }
        return $this->render('amount', ['model' => $model, 'acount' => $user_acount_model]);
    }

    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findUserAcountModel($id) {
        if (($model = UserAcount::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
