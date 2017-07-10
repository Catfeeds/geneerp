<?php

namespace backend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use common\models\Order;
use common\models\OrderGoods;
use common\models\CollectionDoc;
use common\models\DeliveryDoc;
use common\models\RefundmentDoc;
use backend\forms\OrderSearch;
use backend\forms\GoodsSearch;

class OrderController extends _BackendController {

    public function actionIndex() {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }

    public function actionCreate() {
        $model = new Order();
        $model->setScenario('create');
        $model->c_create_type = Order::CREATE_ADMIN;
        if (Yii::$app->request->isPost) {
            if ($this->commonCreate($model)) {
                return $this->redirect(['order/view', 'id' => $model->c_id]);
            }
        }
        $goodsModel = new GoodsSearch();
        $dataProvider = $goodsModel->search(Yii::$app->request->queryParams);

        return $this->render('create', ['model' => $model, 'dataProvider' => $dataProvider]);
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->setScenario('update');
        if (Yii::$app->request->isPost) {
            if ($this->commonUpdate($model)) {
                return $this->refresh();
            }
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionView($id) {
        $model = $this->findModel($id);
        $model->setScenario('note');
        if (Yii::$app->request->isPost) {
            if ($this->commonUpdate($model)) {
                return $this->refresh();
            }
        }

        return $this->render('view', ['model' => $model]);
    }

    public function actionDelivery($id) {
        if (Yii::$app->request->isPost) {
            $result = DeliveryDoc::create($id, Order::CREATE_ADMIN);
            if ($result === true) {
                $this->flashSuccess('订单发货操作成功');
                return $this->redirect(['order/view', 'id' => $id]);
            } else {
                $this->flashError(null, $result);
            }
        }

        $model = $this->findModel($id);
        $dataProvider = new ActiveDataProvider(['query' => OrderGoods::find()->where(['c_order_id' => $id])]);

        return $this->render('delivery', ['model' => $model, 'dataProvider' => $dataProvider]);
    }

    /**
     * 支付
     * @param type $id
     * @return type
     * @throws NotFoundHttpException
     */
    public function actionPay($id) {
        if (Yii::$app->request->isPost) {
            $result = CollectionDoc::create($id, Order::CREATE_ADMIN);
            if ($result === true) {
                $this->flashSuccess('订单支付操作成功');
            } else {
                $this->flashError(null, $result);
            }
        }

        return $this->redirect(['order/view', 'id' => $id]);
    }

    /**
     * 退款
     * @param type $id
     * @return type
     */
    public function actionRefundment($id) {
        if (Yii::$app->request->isPost) {
            $result = RefundmentDoc::create($id, Order::CREATE_ADMIN);
            if ($result === true) {
                $this->flashSuccess('订单退款操作成功');
                return $this->redirect(['order/view', 'id' => $id]);
            } else {
                $this->flashError(null, $result);
            }
        }

        $model = $this->findModel($id);
        $dataProvider = new ActiveDataProvider(['query' => OrderGoods::find()->where(['c_order_id' => $id])]);

        return $this->render('refundment', ['model' => $model, 'dataProvider' => $dataProvider]);
    }

    /**
     * 取消
     * @param type $id
     */
    public function actionCancel($id) {
        if (Yii::$app->request->isAjax) {
            $result = Order::cancel($id, Order::CREATE_ADMIN);
            if ($result === true) {
                $this->ajaxSuccess();
            } else {
                $this->ajaxError();
            }
        }
    }

    /**
     * 确认
     * @param type $id
     */
    public function actionFinish($id) {
        if (Yii::$app->request->isAjax) {
            $result = Order::finish($id, Order::CREATE_ADMIN);
            if ($result === true) {
                $this->ajaxSuccess();
            } else {
                $this->ajaxError($result);
            }
        }
    }

    protected function findModel($id) {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
