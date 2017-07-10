<?php

namespace backend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use common\models\NotityTemplate;
use backend\forms\NotityTemplateSearch;

class NotityTemplateController extends _BackendController {

    public function actionIndex() {
        $searchModel = new NotityTemplateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }

    public function actionCreate() {
        $model = new NotityTemplate();
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
            return $this->commonDelete(NotityTemplate::className(), $id);
        }
    }

    protected function findModel($id) {
        if (($model = NotityTemplate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
