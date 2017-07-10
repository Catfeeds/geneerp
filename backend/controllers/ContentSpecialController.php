<?php

namespace backend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use common\models\ContentSpecial;
use backend\forms\ContentSpecialSearch;

class ContentSpecialController extends _BackendController {

    public function actionIndex() {
        $searchModel = new ContentSpecialSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }

    public function actionCreate() {
        $model = new ContentSpecial();
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
            return $this->commonDelete(ContentSpecial::className(), $id);
        }
    }

    protected function findModel($id) {
        if (($model = ContentSpecial::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
