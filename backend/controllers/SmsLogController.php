<?php

namespace backend\controllers;

use Yii;
use backend\forms\SmsLogSearch;

class SmsLogController extends _BackendController {

    public function actionIndex() {
        $searchModel = new SmsLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }

}
