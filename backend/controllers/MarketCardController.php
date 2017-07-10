<?php

namespace backend\controllers;

use Yii;
use common\models\MarketCard;
use backend\forms\MarketCardSearch;

class MarketCardController extends _BackendController {

    public function actionIndex() {
        $searchModel = new MarketCardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }

    public function actionSend($id) {
        if (Yii::$app->request->isPost) {
            return $this->_send($id);
        }
    }

    public function actionUsed($id) {
        if (Yii::$app->request->isPost) {
            return $this->_used($id);
        }
    }

    public function actionDelete($id) {
        if (Yii::$app->request->isPost) {
            return $this->_delete($id);
        }
    }

    public function actionSendAll() {
        if (Yii::$app->request->isPost) {
            $id = explode(',', Yii::$app->request->post('id'));
            return $this->_send($id, true);
        }
    }

    public function actionUsedAll() {
        if (Yii::$app->request->isPost) {
            $id = explode(',', Yii::$app->request->post('id'));
            return $this->_used($id, true);
        }
    }

    public function actionDeleteAll() {
        if (Yii::$app->request->isPost) {
            $id = explode(',', Yii::$app->request->post('id'));
            return $this->_delete($id, true);
        }
    }

    private function _send($id, $return_ajax = false) {
        return $this->commonUpdateField(MarketCard::className(), ['c_is_send' => MarketCard::STATUS_YES], ['c_id' => $id, 'c_is_send' => MarketCard::STATUS_NO], $return_ajax);
    }

    private function _used($id, $return_ajax = false) {
        return $this->commonUpdateField(MarketCard::className(), ['c_is_used' => MarketCard::STATUS_YES], ['c_id' => $id, 'c_is_send' => MarketCard::STATUS_YES, 'c_is_used' => MarketCard::STATUS_NO], $return_ajax);
    }

    private function _delete($id, $return_ajax = false) {
        return $this->commonUpdateField(MarketCard::className(), ['c_status' => MarketCard::STATUS_NO], ['c_id' => $id, 'c_status' => MarketCard::STATUS_YES, 'c_is_used' => MarketCard::STATUS_NO], $return_ajax);
    }

}
