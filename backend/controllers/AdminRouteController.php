<?php

namespace backend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use backend\forms\AdminRouteSearch;
use backend\models\AdminRoute;

class AdminRouteController extends _BackendController {

    public function actionIndex() {
        $searchModel = new AdminRouteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }

    public function actionCreate() {
        $model = new AdminRoute();
        if (Yii::$app->request->isPost) {
            if ($this->commonCreate($model)) {
                return $this->refresh();
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if (Yii::$app->request->isPost) {
            if ($this->commonUpdate($model)) {
                return $this->refresh();
            }
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id) {
        if (Yii::$app->request->isPost) {
            return $this->commonDelete(AdminRoute::className(), $id);
        }
    }

    protected function findModel($id) {
        if (($model = AdminRoute::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
