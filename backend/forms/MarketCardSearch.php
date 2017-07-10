<?php

namespace backend\forms;

use yii\data\ActiveDataProvider;
use common\models\MarketCard;

class MarketCardSearch extends MarketCard {

    public $pagesize;
    public $keyword;
    public $status;
    public $is_send;
    public $is_used;

    public function rules() {
        return [
            ['keyword', 'filter', 'filter' => 'trim'],
            ['pagesize', 'default', 'value' => 10],
            [['pagesize', 'status', 'is_send', 'is_used'], 'integer'],
        ];
    }

    public function search($params) {
        $query = MarketCard::find();

        if (isset($params['ticket_id'])) {
            $query->andWhere(['c_ticket_id' => (int) $params['ticket_id']]);
        }

        $provider_params = [
            'query' => $query,
            'sort' => ['defaultOrder' => ['c_id' => SORT_DESC]],
            'pagination' => ['pageSize' => 10],
        ];

        if ($this->load($params) && $this->validate()) {

            if ($this->keyword) {
                $query->orFilterWhere(['like', 'c_title', $this->keyword]);
                $query->orFilterWhere(['like', 'c_number', $this->keyword]);
            }

            if ($this->status) {
                $query->andWhere(['c_status' => $this->status]);
            }

            if ($this->is_send) {
                $query->andWhere(['c_is_send' => $this->is_send]);
            }

            if ($this->is_used) {
                $query->andWhere(['c_is_used' => $this->is_used]);
            }

            $provider_params['pagination']['pageSize'] = $this->pagesize;
            $provider_params['query'] = $query;
        }

        return new ActiveDataProvider($provider_params);
    }

}
