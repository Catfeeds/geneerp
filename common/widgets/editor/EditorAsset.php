<?php

namespace common\widgets\editor;

use yii\web\AssetBundle;
use yii\web\View;

class EditorAsset extends AssetBundle {

    public $sourcePath = '@common/widgets/editor/static';
    public $js = [
        'js/kindeditor-all-min.js',
        'js/lang/zh-CN.js'
    ];
    public $jsOptions = ['position' => View::POS_BEGIN];

}
