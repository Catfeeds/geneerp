<?php

namespace backend\forms;

use yii\data\ActiveDataProvider;
use common\models\User;

class UserSearch extends User {

    public $pagesize;
    public $keyword;
    public $status;
    public $group_id;
    public $create_type;
    public $start_time;
    public $end_time;
    private $time_field = 'c_reg_date';

    public function rules() {
        return [
            ['keyword', 'filter', 'filter' => 'trim'],
            ['pagesize', 'default', 'value' => 10],
            [['pagesize', 'status', 'create_type', 'group_id'], 'integer'],
            [['start_time', 'end_time'], 'date']
        ];
    }

    public function search($params) {
        $query = User::find()->with(['userGroup', 'userAcount']);

        $provider_params = [
            'query' => $query,
            'sort' => ['defaultOrder' => ['c_id' => SORT_DESC]],
            'pagination' => ['pageSize' => 10],
        ];

        if ($this->load($params) && $this->validate()) {

            if ($this->keyword) {
                $query->orFilterWhere(['like', 'c_user_name', $this->keyword]);
                $query->orFilterWhere(['like', 'c_mobile', $this->keyword]);
                $query->orFilterWhere(['like', 'c_email', $this->keyword]);
            }

            $time_search_array = self::formatSearchTime($this->time_field, $this->start_time, $this->end_time);
            if ($time_search_array) {
                foreach ($time_search_array as $where) {
                    $query->andWhere($where);
                }
            }

            if ($this->create_type) {
                $query->andWhere(['c_create_type' => $this->create_type]);
            }

            if ($this->group_id) {
                $query->andWhere(['c_group_id' => $this->group_id]);
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
