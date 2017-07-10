<?php

namespace backend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use backend\forms\AdminSearch;
use backend\models\Admin;

class AdminController extends _BackendController {

    public function actionIndex() {
        $searchModel = new AdminSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }

    public function actionView($id) {
        return $this->render('view', ['model' => $this->findModel($id)]);
    }

    public function actionCreate() {
        $model = new Admin();
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

    public function actionUpdatePassword($id) {
        $model = $this->findModel($id);
        $model->setScenario('update-password');
        if ($model->load(Yii::$app->request->post())) {
            if ($model->updatePassword()) {
                $this->flashSuccess();
                return $this->refresh();
            } else {
                $this->flashError($model);
            }
        }

        return $this->render('update-password', ['model' => $model]);
    }

    public function actionDelete($id) {
        if (Yii::$app->request->isPost) {
            $this->commonUpdate($this->findModel($id), ['Admin' => ['c_status' => Admin::STATUS_NO]]);
        }

        return $this->refresh();
    }

    protected function findModel($id) {
        if (($model = Admin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
