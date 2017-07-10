<?php

/**
 * 日期 2016-6-3
 * 作者 19744244@qq.com
 * 名称 计划任务之异步发送短信服务端
 * 使用 根目录下运行 php yii sms
 */

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\SystemLog;
use common\models\NotityTemplate;

class SmsController extends Controller {

    public function actionIndex() {
        while (true) {
            try {
                $data = Yii::$app->redis->lpop('sms'); //弹出第一个列表值
                if ($data) {
                    $array = json_decode($data, true);
                    $result = NotityTemplate::commonSendSms($array);
                    if (YII_DEBUG) {
                        echo $result . "\n";
                    }
                    sleep(1);
                }
            } catch (\Exception $ex) {
                SystemLog::add($ex->getMessage());
            }
        }
    }

}
