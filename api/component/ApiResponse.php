<?php

namespace api\component;

use yii\web\Response;

class ApiResponse extends Response {

    public $api_success = 1; //操作 1成功 0失败
    public $api_message = 'OK';

}
