<?php

namespace common\widgets\uploader;

use yii\web\AssetBundle;
use yii\web\View;

class UploaderAsset extends AssetBundle {

    public $sourcePath = '@common/widgets/uploader/static';
    public $css = ['css/css.css'];
    public $js = ['js/plupload.full.min.js'];
    public $jsOptions = ['position' => View::POS_BEGIN];

}
