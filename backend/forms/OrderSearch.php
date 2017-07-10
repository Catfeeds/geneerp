<?php

namespace backend\forms;

use yii\data\ActiveDataProvider;
use common\models\Order;

class OrderSearch extends Order {

    public $pagesize;
    public $keyword;
    public $order_status;
    public $order_type;
    public $pay_status;
    public $delivery_id;
    public $distribution_status;

    public function rules() {
        return [
            ['keyword', 'filter', 'filter' => 'trim'],
            ['pagesize', 'default', 'value' => 10],
            [['pagesize', 'order_status', 'order_type', 'pay_status', 'delivery_id', 'distribution_status'], 'integer'],
        ];
    }

    public function search($params) {
        $query = Order::find()->with(['delivery','payment']);

        $provider_params = [
            'query' => $query,
            'sort' => ['defaultOrder' => ['c_id' => SORT_DESC]],
            'pagination' => ['pageSize' => 10],
        ];

        if ($this->load($params) && $this->validate()) {
            if ($this->keyword) {
                $query->orFilterWhere(['like', 'c_order_no', $this->keyword]);
                $query->orFilterWhere(['like', 'c_phone', $this->keyword]);
                $query->orFilterWhere(['like', 'c_user_name', $this->keyword]);
                $query->orFilterWhere(['like', 'c_full_name', $this->keyword]);
                $query->orFilterWhere(['like', 'c_mobile', $this->keyword]);
                $query->orFilterWhere(['like', 'c_address', $this->keyword]);
                $query->orFilterWhere(['like', 'c_trade_no', $this->keyword]);
            }

            if ($this->order_status) {
                $query->andWhere(['c_order_status' => $this->order_status]);
            }

            if ($this->order_type) {
                $query->andWhere(['c_order_type' => $this->order_type]);
            }

            if ($this->pay_status) {
                $query->andWhere(['c_pay_status' => $this->pay_status]);
            }

            if ($this->delivery_id) {
                $query->andWhere(['c_delivery_id' => $this->delivery_id]);
            }

            if ($this->distribution_status) {
                $query->andWhere(['c_distribution_status' => $this->distribution_status]);
            }

            $provider_params['pagination']['pageSize'] = $this->pagesize;
            $provider_params['query'] = $query;
        }

        return new ActiveDataProvider($provider_params);
    }

}
