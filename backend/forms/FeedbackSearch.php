<?php

namespace backend\forms;

use yii\data\ActiveDataProvider;
use common\models\Feedback;

class FeedbackSearch extends Feedback {

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
        $query = Feedback::find();

        $provider_params = [
            'query' => $query,
            'sort' => ['defaultOrder' => ['c_id' => SORT_DESC]],
            'pagination' => ['pageSize' => 10],
        ];

        if ($this->load($params) && $this->validate()) {

            if ($this->keyword) {
                $query->orFilterWhere(['like', 'c_mobile', $this->keyword]);
                $query->orFilterWhere(['like', 'c_user_name', $this->keyword]);
                $query->orFilterWhere(['like', 'c_full_name', $this->keyword]);
                $query->orFilterWhere(['like', 'c_email', $this->keyword]);
                $query->orFilterWhere(['like', 'c_phone', $this->keyword]);
                $query->orFilterWhere(['like', 'c_title', $this->keyword]);
                $query->orFilterWhere(['like', 'c_note', $this->keyword]);
                $query->orFilterWhere(['like', 'c_admin_name', $this->keyword]);
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
