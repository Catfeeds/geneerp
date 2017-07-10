<?php

namespace backend\forms;

use yii\data\ActiveDataProvider;
use backend\models\AdminRoute;

class AdminRouteSearch extends AdminRoute {

    public $pagesize;
    public $keyword;
    public $status;

    public function rules() {
        return [
            ['keyword', 'filter', 'filter' => 'trim'],
            ['pagesize', 'default', 'value' => 10],
            [['pagesize', 'status'], 'integer'],
        ];
    }

    public function search($params) {
        $query = AdminRoute::find();

        $provider_params = [
            'query' => $query,
            'sort' => ['defaultOrder' => ['c_sort' => SORT_DESC, 'c_id' => SORT_DESC]],
            'pagination' => ['pageSize' => 10],
        ];

        $parent_id = isset($params['parent_id']) ? (int) $params['parent_id'] : 0;

        if ($this->load($params) && $this->validate()) {
            if (empty($this->status) && empty($this->keyword)) {
                $query->andWhere(['c_parent_id' => $parent_id]);
            } else {
                if ($this->keyword) {
                    $query->orFilterWhere(['like', 'c_title', $this->keyword]);
                    $query->orFilterWhere(['like', 'c_route', $this->keyword]);
                }

                if ($this->status) {
                    $query->andWhere(['c_status' => $this->status]);
                }
            }

            $provider_params['pagination']['pageSize'] = $this->pagesize;
        } else {
            $query->andWhere(['c_parent_id' => $parent_id]);
        }

        $provider_params['query'] = $query;

        return new ActiveDataProvider($provider_params);
    }

}
