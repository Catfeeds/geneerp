<?php

namespace common\widgets\online;

use Yii;
use yii\base\Widget;

class Online extends Widget {

    public function run() {
        if (Yii::$app->params['qq_open'] === '1') {
            $list = Yii::$app->params['qq_list'];
            if (strpos($list, '|') !== false) {
                return $this->render('online', ['list' => explode(',', $list)]);
            }
        }
    }

}
