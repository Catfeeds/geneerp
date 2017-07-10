<?php

namespace backend\forms;

use yii\data\ActiveDataProvider;
use common\models\UserPointLog;

class UserPointLogSearch extends UserPointLog {

    public $pagesize;
    public $keyword;
    public $type;

    public function rules() {
        return [
            ['keyword', 'filter', 'filter' => 'trim'],
            ['pagesize', 'default', 'value' => 10],
            [['pagesize', 'type'], 'integer'],
        ];
    }

    public function search($params) {
        $query = UserPointLog::find();

        $provider_params = [
            'query' => $query,
            'sort' => ['defaultOrder' => [ 'c_id' => SORT_DESC]],
            'pagination' => ['pageSize' => 10],
        ];

        if ($this->load($params) && $this->validate()) {

            if ($this->keyword) {
                $keyword = $this->keyword;
                $user = function ($query) use($keyword) {
                    $query->orFilterWhere(['like', 'c_user_name', $keyword]);
                    $query->orFilterWhere(['like', 'c_email', $keyword]);
                    $query->orFilterWhere(['like', 'c_mobile', $keyword]);
                };
                $query->innerJoinWith(['user' => $user]);
            }

            if ($this->type) {
                $query->andWhere(['c_type' => $this->type]);
            }

            $provider_params['pagination']['pageSize'] = $this->pagesize;
            $provider_params['query'] = $query;
        }

        return new ActiveDataProvider($provider_params);
    }

}
