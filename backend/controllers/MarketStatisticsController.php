<?php

namespace backend\controllers;

use Yii;
use backend\forms\StatisticsSearch;

class MarketStatisticsController extends _BackendController {

    public function actionRegister() {
        $searchModel = new StatisticsSearch();
        $data = $searchModel->userStatistics(Yii::$app->request->queryParams);
        $data['searchModel'] = $searchModel;

        return $this->render('register', $data);
    }

    public function actionSales() {
        $searchModel = new StatisticsSearch();
        $data = $searchModel->salesStatistics(Yii::$app->request->queryParams);
        $data['searchModel'] = $searchModel;

        return $this->render('sales', $data);
    }

}
