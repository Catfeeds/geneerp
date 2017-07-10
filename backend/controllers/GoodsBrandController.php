<?php

namespace backend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use common\models\GoodsBrand;

class GoodsBrandController extends _BackendController {

    public function actionIndex() {
        $dataProvider = new ActiveDataProvider(['query' => GoodsBrand::find()]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionCreate() {
        $model = new GoodsBrand();
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
            return $this->commonDelete(GoodsBrand::className(), $id);
        }
    }

    protected function findModel($id) {
        if (($model = GoodsBrand::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
