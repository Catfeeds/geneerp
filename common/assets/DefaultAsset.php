<?php

namespace common\assets;

use yii\web\AssetBundle;
use yii\web\View;

class DefaultAsset extends AssetBundle {

    public $sourcePath = '@common/static';
    public $css = [
        'css/bootstrap.min.css',
        'css/bootstrap-theme.min.css',
        'css/style.css'
    ];
    public $js = [
        'js/jquery/jquery.min.js',
        'js/jquery.birthday.js',
        'js/layer/layer.js',
        'js/validator/jquery.validator.min.js?local=zh-CN',
        'js/common.js',
        'js/send.js',
        'js/bootstrap.min.js'
    ];
    public $jsOptions = ['position' => View::POS_HEAD];

}
