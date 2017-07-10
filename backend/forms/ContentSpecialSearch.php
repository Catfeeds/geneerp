<?php

namespace backend\forms;

use yii\data\ActiveDataProvider;
use common\models\ContentSpecial;

class ContentSpecialSearch extends ContentSpecial {

    public $pagesize;
    public $keyword;
    public $status;
    public $type;
    public $home_block;

    public function rules() {
        return [
            ['keyword', 'filter', 'filter' => 'trim'],
            ['pagesize', 'default', 'value' => 10],
            [['pagesize', 'status', 'type', 'home_block'], 'integer'],
        ];
    }

    public function search($params) {
        $query = ContentSpecial::find();

        $provider_params = [
            'query' => $query,
            'sort' => ['defaultOrder' => ['c_sort' => SORT_DESC, 'c_id' => SORT_DESC]],
            'pagination' => ['pageSize' => 10],
        ];

        $parent_id = isset($params['parent_id']) ? (int) $params['parent_id'] : 0;

        if ($this->load($params) && $this->validate()) {

            if (empty($this->status) && empty($this->type) && empty($this->home_block) && empty($this->keyword)) {
                $query->andWhere(['c_parent_id' => $parent_id]);
            } else {
                if ($this->keyword) {
                    $query->orFilterWhere(['like', 'c_title', $this->keyword]);
                }

                if ($this->status) {
                    $query->andWhere(['c_status' => $this->status]);
                }

                if ($this->type) {
                    $query->andWhere(['c_type' => $this->type]);
                }

                if ($this->home_block) {
                    $query->andWhere(['c_home_block' => $this->home_block]);
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
