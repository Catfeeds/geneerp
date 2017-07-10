<?php

namespace backend\forms;

use yii\data\ActiveDataProvider;
use common\models\ContentCategory;

class ContentCategorySearch extends ContentCategory {

    public $pagesize;
    public $keyword;
    public $status;
    public $home_block;
    public $model_id;

    public function rules() {
        return [
            ['keyword', 'filter', 'filter' => 'trim'],
            ['pagesize', 'default', 'value' => 10],
            [['pagesize', 'status', 'home_block', 'model_id'], 'integer'],
        ];
    }

    public function search($params) {
        $query = ContentCategory::find()->with('contentModel');

        $provider_params = [
            'query' => $query,
            'sort' => ['defaultOrder' => ['c_sort' => SORT_DESC, 'c_id' => SORT_DESC]],
            'pagination' => ['pageSize' => 10],
        ];

        $parent_id = isset($params['parent_id']) ? (int) $params['parent_id'] : 0;

        if ($this->load($params) && $this->validate()) {

            if (empty($this->status) && empty($this->home_block) && empty($this->model_id) && empty($this->keyword)) {
                $query->andWhere(['c_parent_id' => $parent_id]);
            } else {
                if ($this->keyword) {
                    $query->orFilterWhere(['like', 'c_title', $this->keyword]);
                }

                if ($this->status) {
                    $query->andWhere(['c_status' => $this->status]);
                }

                if ($this->home_block) {
                    $query->andWhere(['c_home_block' => $this->home_block]);
                }

                if ($this->model_id) {
                    $query->andWhere(['c_model_id' => $this->model_id]);
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
