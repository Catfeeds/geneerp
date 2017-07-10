<?php

namespace backend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use common\models\Payment;

class PaymentController extends _BackendController {

    public function actionIndex() {
        $dataProvider = new ActiveDataProvider(['query' => Payment::find()]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
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

    protected function findModel($id) {
        if (($model = Payment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
