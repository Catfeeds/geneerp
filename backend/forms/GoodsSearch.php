<?php

namespace backend\forms;

use yii\data\ActiveDataProvider;
use common\models\Goods;

class GoodsSearch extends Goods {

    public $pagesize;
    public $keyword;
    public $status;
    public $category_id;
    public $brand_id;
    public $label_id;

    public function rules() {
        return [
            ['keyword', 'filter', 'filter' => 'trim'],
            ['pagesize', 'default', 'value' => 10],
            [['pagesize', 'status', 'category_id', 'brand_id', 'label_id'], 'integer'],
        ];
    }

    public function search($params) {
        $query = Goods::find()->with(['goodsCategoryExtend', 'goodsBrand']);

        $provider_params = [
            'query' => $query,
            'sort' => ['defaultOrder' => ['c_sort' => SORT_DESC, 'c_id' => SORT_DESC]],
            'pagination' => ['pageSize' => 10],
        ];

        if ($this->load($params) && $this->validate()) {
            if ($this->keyword) {
                $query->orFilterWhere(['like', 'c_title', $this->keyword]);
                $query->orFilterWhere(['like', 'c_number', $this->keyword]);
                $query->orFilterWhere(['like', 'c_search_keyword', $this->keyword]);
            }

            if ($this->status) {
                $query->andWhere(['c_status' => $this->status]);
            }

            if ($this->brand_id) {
                $query->andWhere(['c_brand_id' => $this->brand_id]);
            }

            if ($this->category_id) {
                $query->andWhere(['c_category_id' => $this->category_id]);
            }

            if ($this->label_id) {
                $label = $this->label_id;
                $with_label = function($query) use ($label) {
                    $query->andWhere(['c_type' => $label]);
                };
                $query->innerJoinWith(['contentLabel' => $with_label]);
            } else {
                $query->with('contentLabel');
            }

            $provider_params['pagination']['pageSize'] = $this->pagesize;
            $provider_params['query'] = $query;
        }

        return new ActiveDataProvider($provider_params);
    }

}
