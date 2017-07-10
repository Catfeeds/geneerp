<?php

namespace api\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use common\models\Upload;
use common\extensions\Util;

class _ApiController extends ActiveController {

    //过滤不需要验证的action
    private $_active_array = ['login'];
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function behaviors() {
        //下面是三种验证access_token方式
        //1.HTTP 基本认证: access token 当作用户名发送，应用在access token可安全存在API使用端的场景，例如，API使用端是运行在一台服务器上的程序。
        //HttpBasicAuth::className()
        //2.OAuth 2: 使用者从认证服务器上获取基于OAuth2协议的access token，然后通过 HTTP Bearer Tokens 发送到API 服务器。
        //HttpBearerAuth::className()
        //Header 中加入一项：Authorization:Bearer ganiks-token
        //3.请求参数: access token 当作API URL请求参数发送，这种方式应主要用于JSONP请求，因为它不能使用HTTP头来发送access token
        //QueryParamAuth::className()
        //http://localhost/user/1?access-token=123
        return ArrayHelper::merge(parent::behaviors(), [
                    'authenticator' => [
                        'class' => HttpBearerAuth::className(),
                        'optional' => $this->_active_array  //过滤不需要验证的action
                    ],
                    [
                        'class' => Cors::className(),
                    //'cors' => [
                    //'Origin' => ['http://api.domain.com'], //定义允许来源的数组
                    //'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'DELETE', 'HEAD', 'OPTIONS'], //允许动作的数组
                    //'Access-Control-Allow-Credentials' => true,
                    //],
                    ],
        ]);
    }

    public function actions() {
        $actions = parent::actions();
        unset($actions['index'], $actions['view'], $actions['create'], $actions['update'], $actions['delete'], $actions['options']);

        return $actions;
    }

    public function successJson($data = null) {
        $response = Yii::$app->response;
        $response->api_success = 1;
        $response->data = $data;
    }

    public function errorJson($message = null) {
        $response = Yii::$app->response;
        $response->api_success = 0;
        $response->api_message = $message;
    }

    public function errorModelJson($model) {
        $error = $model->getFirstErrors();
        $message = array_values($error)[0];
        $this->errorJson($message);
    }

    public function upload($base64, $object_id = 0, $extension = 'jpg') {
        $img = base64_decode($base64);
        $info = Upload::getUploadInfo('', $extension);
        $file_path = Upload::getUploadPath() . $info['path']; //文件上传的路径
        Util::createDirList($file_path); //生成目录
        if (file_put_contents($file_path, $img)) {
            $data = [];
            $data['c_name'] = $info['name'];
            $data['c_size'] = 0;
            $data['c_path'] = $info['url'];
            $data['c_extension'] = 'png';
            $data['c_object_id'] = $object_id;
            $data['c_user_type'] = 2; //用户类型 1后台 2前台
            $data['c_type'] = 1; //文件类型 1图片 2附件
            if (Upload::add($data)) {
                return $info['url']; //20170505/05/05/aaaa.jpg
            }
        }
        return false;
    }

}
