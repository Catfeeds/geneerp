<?php

namespace backend\forms;

use yii\data\ActiveDataProvider;
use common\models\NotityTemplate;

class NotityTemplateSearch extends NotityTemplate {

    public $pagesize;
    public $keyword;
    public $status;
    public $type;

    public function rules() {
        return [
            ['keyword', 'filter', 'filter' => 'trim'],
            ['pagesize', 'default', 'value' => 10],
            [['pagesize', 'status', 'type'], 'integer'],
        ];
    }

    public function search($params) {
        $query = NotityTemplate::find();

        $provider_params = [
            'query' => $query,
            'sort' => ['defaultOrder' => ['c_sort' => SORT_DESC, 'c_id' => SORT_DESC]],
            'pagination' => ['pageSize' => 10],
        ];

        if ($this->load($params) && $this->validate()) {

            if ($this->keyword) {
                $query->orFilterWhere(['like', 'c_title', $this->keyword]);
            }

            if ($this->type) {
                $query->andWhere(['c_type' => $this->type]);
            }

            if ($this->status) {
                $query->andWhere(['c_status' => $this->status]);
            }

            $provider_params['pagination']['pageSize'] = $this->pagesize;
            $provider_params['query'] = $query;
        }

        return new ActiveDataProvider($provider_params);
    }

}
