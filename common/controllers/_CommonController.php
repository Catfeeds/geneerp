<?php

namespace common\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use common\extensions\Util;
use common\extensions\Captcha;
use common\models\Upload;
use common\models\UploadForm;
use common\messages\Common;

class _CommonController extends Controller {

    //母版类型
    const MAIN_LAYOUT = 1; //无导航（常用于登录或Ajax弹出窗口）
    const NAV_LAYOUT = 2; //有导航（常用于列表）

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * 获取验证码
     */
    public function actionCaptcha() {
        $object = new Captcha();
        $object->config();
        $object->make();
    }

    public function returnAjaxError($model, $type = 1) {
        $error = $model->getFirstErrors();
        $message = $error ? array_values($error)[0] : null;
        $this->ajaxError($message, $type);
    }

    /**
     *  Ajax返回状态信息
     * @param type $msg 信息提示
     * @param type $type 
     * 1  弹出信息，3秒后自动消失 
     * 2  弹出信息，2秒后自动重定向，URL参数必填
     * 3  弹出信息，2秒后自动重载当前页
     * 4  弹出信息，2秒后自动返回上一页
     * 5  无信息提示，自动重定向，URL参数必填
     * 6  无信息提示，自动重载当前页
     * 7  无信息提示，自动返回上一页
     * @param type $url 重定向连接
     */
    protected function ajaxSuccess($msg = null, $type = 3, $url = '') {
        if (empty($msg)) {
            $msg = Yii::t('common', Common::SYSTEM_OPERATION_SUCCESS);
        }
        $array['status'] = 1;
        $array['type'] = $type;
        $array['msg'] = $msg;
        $array['url'] = $url;
        self::jsonEcho($array);
    }

    /**
     *  Ajax返回状态信息
     * @param type $msg 信息提示
     * @param type $type 
     * 0  关闭弹窗
     * 1  弹出信息，2秒后自动消失 
     * 2  弹出信息，自动重定向，URL参数必填
     * 3  弹出信息，自动重载当前页
     * 4  弹出信息，自动返回上一页
     * 5  无信息提示，自动重定向，URL参数必填
     * 6  无信息提示，自动重载当前页
     * 7  无信息提示，自动返回上一页
     * @param type $url 重定向连接
     */
    protected function ajaxError($msg = null, $type = 1, $url = '') {
        if (empty($msg)) {
            $msg = Yii::t('common', Common::SYSTEM_OPERATION_FAIL);
        }
        $array['status'] = 0;
        $array['type'] = $type;
        $array['msg'] = $msg;
        $array['url'] = $url;
        self::jsonEcho($array);
    }

    /**
     * 公共图片上传文件
     * @param type $userType 用户类型 1后台 2前台
     */
    protected function pictureUpload($userType = 1) {
        try {
            if (Yii::$app->request->isPost) {
                $object_id = (int) Yii::$app->request->post('object_id'); //文档对象关联ID

                $model = new UploadForm();
                $model->picture = UploadedFile::getInstance($model, 'picture'); //参数picture是指input上传控件name

                if ($model->picture && !in_array($model->picture->extension, Yii::$app->params['image_extensions'])) {
                    self::jsonFormat('只允许上传文件的后缀为 ' . implode(',', Yii::$app->params['image_extensions']));
                }
                if ($model->validate()) {
                    $info = Upload::getUploadInfo($model->picture->baseName, $model->picture->extension);
                    $file_path = Upload::getUploadPath() . $info['path']; //文件上传的路径
                    $file_url = $info['url']; //图片路径
                    Util::createDirList($file_path); //生成目录
                    $result = $model->picture->saveAs($file_path); //保存上传文件

                    if ($result === true) {
                        $data = [];
                        $data['c_name'] = $model->picture->name;
                        $data['c_size'] = $model->picture->size;
                        $data['c_path'] = $file_url;
                        $data['c_extension'] = $model->picture->extension;
                        $data['c_object_id'] = $object_id;
                        $data['c_user_type'] = $userType; //用户类型 1后台 2前台
                        $data['c_type'] = 1; //文件类型 1图片 2附件
                        Upload::add($data);
                        self::jsonEcho(['error' => 0, 'thumb' => Upload::getThumb($file_url), 'fileurl' => $file_url]);
                    }
                } else {
                    $error = $model->getFirstErrors();
                    $message = $error ? array_values($error)[0] : '规则验证失败，而且错误信息为空';
                    self::jsonFormat($message);
                }
            } else {
                self::jsonFormat('上传失败');
            }
        } catch (\Exception $exc) {
            self::jsonFormat($exc->getMessage());
        }
    }

    /**
     * 公共上传文件
     * @param type $userType 用户类型 1后台 2前台
     */
    protected function fileUpload($userType = 1) {
        try {
            if (Yii::$app->request->isPost) {
                $dir = Yii::$app->request->get('dir'); //获取编辑器上传允许的目录  $config['editor_dir'] = ['image', 'flash', 'media', 'file'];
                $object_id = (int) Yii::$app->request->post('object_id'); //文档对象关联ID

                $model = new UploadForm();
                $model->file = UploadedFile::getInstance($model, 'file');
                if ($model->file && !in_array($model->file->extension, Yii::$app->params['file_extensions'])) {
                    self::jsonFormat('只允许上传文件的后缀为 ' . implode(',', Yii::$app->params['file_extensions']));
                }
                if ($model->validate()) {
                    $info = Upload::getUploadInfo($model->file->baseName, $model->file->extension);
                    $file_url = $info['url']; //返回上传的URL
                    $file_path = Upload::getUploadPath() . $info['path']; //上传的文件路径
                    $http_url = Upload::getUploadUrl() . $file_url;

                    if ($dir && in_array($dir, Yii::$app->params['editor_dir'])) {
                        $file_url = $dir . '/' . $file_url; //保存上传的URL
                        $file_path = Upload::getUploadPath() . $dir . DIRECTORY_SEPARATOR . $info['path']; //编辑器存放的路径
                        $http_url = Upload::getUploadUrl() . $file_url; //编辑器返回的上传绝对URL
                    }

                    Util::createDirList($file_path); //生成目录
                    $result = $model->file->saveAs($file_path); //保存上传文件

                    if ($result === true) {
                        $data['c_name'] = $model->file->name;
                        $data['c_size'] = $model->file->size;
                        $data['c_path'] = $file_url;
                        $data['c_extension'] = $model->file->extension;
                        $data['c_object_id'] = $object_id;
                        $data['c_user_type'] = $userType; //用户类型 1后台 2前台
                        $data['c_type'] = 2; //文件类型 1图片 2附件
                        Upload::add($data);
                        //thumb 缩略图地址 http://file.domain.com/thumb/200_200/2017/02/10/13/f944ff5cffc05852881c6a92f6b8e826.png
                        //fileurl 数据库保存地址 2017/02/10/13/f944ff5cffc05852881c6a92f6b8e826.png
                        //url 图片地址 http://file.domain.com/2017/02/10/13/f944ff5cffc05852881c6a92f6b8e826.png
                        if ($dir) {
                            self::jsonEcho(['error' => 0, 'url' => $http_url]);
                        } else {
                            $thumb = in_array($model->file->extension, Yii::$app->params['image_extensions']) ? Upload::getThumb($file_url) : Upload::getFilePic(); //如果是图片格式就显示缩略图否则就是附件缩略图
                            self::jsonEcho(['error' => 0, 'thumb' => $thumb, 'fileurl' => $file_url]);
                        }
                    }
                } else {
                    $error = $model->getFirstErrors();
                    $message = $error ? array_values($error)[0] : '规则验证失败，而且错误信息为空';
                    self::jsonFormat($message);
                }
            } else {
                self::jsonFormat('上传失败');
            }
        } catch (\Exception $exc) {
            self::jsonFormat($exc->getMessage());
        }
    }

    public static function jsonFormat($message, $error = 1) {
        self::jsonEcho(['error' => $error, 'message' => $message]);
    }

    public static function jsonEcho($array) {
        echo json_encode($array);
        Yii::$app->end();
    }

}
