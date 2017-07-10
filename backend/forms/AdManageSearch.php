<?php

namespace backend\forms;

use yii\data\ActiveDataProvider;
use common\models\AdManage;

class AdManageSearch extends AdManage {

    public $pagesize;
    public $keyword;
    public $status;
    public $type;
    public $position_id;

    public function rules() {
        return [
            ['keyword', 'filter', 'filter' => 'trim'],
            ['pagesize', 'default', 'value' => 10],
            [['pagesize', 'status', 'type', 'position_id'], 'integer'],
        ];
    }

    public function search($params) {
        $query = AdManage::find()->with('adPosition');

        $provider_params = [
            'query' => $query,
            'sort' => ['defaultOrder' => ['c_sort' => SORT_DESC, 'c_id' => SORT_DESC]],
            'pagination' => ['pageSize' => 10],
        ];

        if ($this->load($params) && $this->validate()) {

            if ($this->keyword) {
                $query->orFilterWhere(['like', 'c_title', $this->keyword]);
                $query->orFilterWhere(['like', 'c_url', $this->keyword]);
            }

            if ($this->status) {
                $query->andWhere(['c_status' => $this->status]);
            }

            if ($this->type) {
                $query->andWhere(['c_type' => $this->type]);
            }

            if ($this->position_id) {
                $query->andWhere(['c_position_id' => $this->position_id]);
            }

            $provider_params['pagination']['pageSize'] = $this->pagesize;
            $provider_params['query'] = $query;
        }

        return new ActiveDataProvider($provider_params);
    }

}
