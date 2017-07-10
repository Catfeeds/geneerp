<?php

namespace frontend\controllers;

use Yii;
use common\models\Upload;

class UploaderController extends _UserController {

    public function actionPicture() {
        if (Yii::$app->params['upload_picture_status'] === '1') {
            $this->pictureUpload(2);
        } else {
            self::jsonFormat('图片上传功能已关闭');
        }
    }

    public function actionFile() {
        if (Yii::$app->params['upload_file_status'] === '1') {
            $this->fileUpload(2);
        } else {
            self::jsonFormat('附件上传功能已关闭');
        }
    }

    public function actionDelete() {
        $path = Yii::$app->request->post('path');
        $result = Upload::deleteFile($path, true);
        $result ? $this->ajaxSuccess() : $this->ajaxError();
    }

}
