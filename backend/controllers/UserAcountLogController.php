<?php

namespace backend\controllers;

use Yii;
use backend\forms\UserAcountLogSearch;

class UserAcountLogController extends _BackendController {

    public function actionIndex() {
        $searchModel = new UserAcountLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }

}
