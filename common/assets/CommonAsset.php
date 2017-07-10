<?php

namespace common\assets;

use yii\web\AssetBundle;
use yii\web\View;

class CommonAsset extends AssetBundle {

    public $sourcePath = '@common/static';
    public $js = [
        'js/linkagesel/linkagesel.min.js',
        'js/linkagesel/district-level1.js',
        'js/linkagesel/district-all.js',
    ];
    public $jsOptions = ['position' => View::POS_HEAD];

}
