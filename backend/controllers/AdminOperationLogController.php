<?php

namespace backend\controllers;

use Yii;
use backend\forms\AdminOperationLogSearch;

class AdminOperationLogController extends _BackendController {

    public function actionIndex() {
        $searchModel = new AdminOperationLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }

}
