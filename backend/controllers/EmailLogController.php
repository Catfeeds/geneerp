<?php

namespace backend\controllers;

use Yii;
use backend\forms\EmailLogSearch;

class EmailLogController extends _BackendController {

    public function actionIndex() {
        $searchModel = new EmailLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }

}
