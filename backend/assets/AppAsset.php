<?php

namespace backend\assets;

use Yii;
use yii\web\AssetBundle;

class AppAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/AdminLTE.css',
        'css/skins/_all-skins.css',
        'js/datetimepicker/datetimepicker.min.css',
    ];
    public $js = [
        'js/app.min.js',
        'js/bootbox.js',
        'js/datetimepicker/datetimepicker.min.js',
        'js/backend.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

    public static function overrideSystemConfirm() {
        Yii::$app->view->registerJs('
            yii.confirm = function(message, ok, cancel) {
                bootbox.setLocale("zh_CN");
                bootbox.confirm(message, function(result) {
                    if (result) { !ok || ok(); } else { !cancel || cancel(); }
                });
                return false;
            }
        ');
    }

    public static function addScript($js) {
        Yii::$app->view->registerJs($js);
    }

    public static function registerJsFile($jsfile) {
        Yii::$app->view->registerJsFile($jsfile);
    }

}
