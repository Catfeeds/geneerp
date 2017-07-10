<?php

namespace backend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use common\models\Feedback;
use backend\forms\FeedbackSearch;

class FeedbackController extends _BackendController {

    public function actionIndex() {
        $searchModel = new FeedbackSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }

    public function actionView($id) {
        $model = $this->findModel($id);

        return $this->render('view', ['model' => $model]);
    }

    public function actionOperation($id) {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            if ($this->commonUpdate($model)) {
                return $this->refresh();
            }
        }

        return $this->render('operation', ['model' => $model]);
    }

    public function actionDelete($id) {
        if (Yii::$app->request->isPost) {
            return $this->commonDelete(Feedback::className(), $id);
        }
    }

    protected function findModel($id) {
        if (($model = Feedback::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
