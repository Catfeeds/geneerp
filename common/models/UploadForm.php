<?php

namespace common\models;

use Yii;
use yii\base\Model;

class UploadForm extends Model {

    public $file;
    public $picture;

    public function rules() {
        return [
            ['picture', 'image', 'skipOnEmpty' => true, 'extensions' => Yii::$app->params['image_extensions'], 'mimeTypes' => ['image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'], 'maxSize' => (1024 * 1024)], //文件大小必须小于 1MB
            ['file', 'file', 'skipOnEmpty' => true, 'maxSize' => (2 * 1024 * 1024)], //文件大小必须小于 2MB
        ];
    }

}
