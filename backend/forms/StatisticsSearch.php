<?php

namespace backend\forms;

use common\models\_CommonModel;
use common\models\User;
use common\models\CollectionDoc;

class StatisticsSearch extends _CommonModel {

    public $start_time;
    public $end_time;

    public function rules() {
        return [
            [['start_time', 'end_time'], 'filter', 'filter' => 'trim'],
        ];
    }

    public function userStatistics($params) {
        $key = $value = [];
        if ($this->load($params) && $this->validate()) {
            $time_field = 'c_reg_date';
            $query = User::find()->select([$time_field, 'count(c_id) AS count']);
            $time_search_array = self::formatSearchTime($time_field, $this->start_time, $this->end_time);
            if ($time_search_array) {
                foreach ($time_search_array as $where) {
                    $query->andWhere($where);
                }
            }
            $result = $query->groupBy([$time_field])->asArray()->all();

            foreach ($result as $v) {
                $key[] = date('Y-m-d', $v[$time_field]);
                $value[] = $v['count'];
            }
        }

        return ['key' => json_encode($key), 'value' => json_encode($value)];
    }

    public function salesStatistics($params) {
        $key = $value = [];
        if ($this->load($params) && $this->validate()) {
            $time_field = 'c_create_time';
            $query = CollectionDoc::find()->select([$time_field, 'sum(c_amount)/count(*) AS count']);
            $time_search_array = self::formatSearchTime($time_field, $this->start_time, $this->end_time);
            if ($time_search_array) {
                foreach ($time_search_array as $where) {
                    $query->andWhere($where);
                }
            }
            $result = $query->asArray()->all();

            foreach ($result as $v) {
                $key[] = date('Y-m-d', $v[$time_field]);
                $value[] = $v['count'];
            }
        }

        return ['key' => json_encode($key), 'value' => json_encode($value)];
    }

}
