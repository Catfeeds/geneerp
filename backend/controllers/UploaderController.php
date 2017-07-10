<?php

namespace backend\controllers;

use Yii;
use common\models\Upload;

class UploaderController extends _BackendController {

    public function actionPicture() {
        if (Yii::$app->params['upload_picture_status'] === '1') {
            $this->pictureUpload();
        } else {
            echo json_encode(['error' => 1, 'message' => '请至后台【系统设置】打开图片上传功能']);
        }
    }

    public function actionFile() {
        if (Yii::$app->params['upload_file_status'] === '1') {
            $this->fileUpload();
        } else {
            echo json_encode(['error' => 1, 'message' => '请至后台【系统设置】打开附件上传功能']);
        }
    }

    public function actionDelete() {
        $path = Yii::$app->request->post('path');
        $result = Upload::deleteFile($path, true); //TODO 需要加入日志操作
        $result ? $this->ajaxSuccess() : $this->ajaxError();
    }

}
