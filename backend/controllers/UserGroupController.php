<?php

namespace backend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use common\models\UserGroup;

class UserGroupController extends _BackendController {

    public function actionIndex() {
        $dataProvider = new ActiveDataProvider(['query' => UserGroup::find()]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionCreate() {
        $model = new UserGroup();
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
            return $this->commonDelete(UserGroup::className(), $id);
        }
    }

    protected function findModel($id) {
        if (($model = UserGroup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
