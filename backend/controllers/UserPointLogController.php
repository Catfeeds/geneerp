<?php

namespace backend\controllers;

use Yii;
use backend\forms\UserPointLogSearch;

class UserPointLogController extends _BackendController {

    public function actionIndex() {
        $searchModel = new UserPointLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }

}
