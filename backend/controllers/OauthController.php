<?php

namespace backend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use common\models\Oauth;

class OauthController extends _BackendController {

    public function actionIndex() {
        $dataProvider = new ActiveDataProvider(['query' => Oauth::find()]);

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
        if (($model = Oauth::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
