<?php

namespace common\assets;

use yii\web\AssetBundle;
use yii\web\View;

class EchartsAsset extends AssetBundle {

    public $sourcePath = '@common/static';
    public $js = [
        'js/echarts.common.min.js',
    ];
    public $jsOptions = ['position' => View::POS_HEAD];

}
