<?php

use yii\helpers\Url;
use yii\helpers\Html;
use common\extensions\Util;
use common\extensions\CheckRule;
use backend\widgets\GridView;
use backend\widgets\SearchForm;

$this->title = '促销活动列表';
?>
<div class="box box-primary">
    <div class="box-header">
        <div class="pull-left">

        </div>
        <?php if (CheckRule::checkRole('market-activity/create')) { ?>
            <div class="pull-right">
                <?= Html::a('<i class="glyphicon glyphicon-plus"></i> 新增', Url::to(['create']), ['class' => 'btn btn-success']) ?>
            </div>
        <?php } ?>
    </div>
    <div class="box-body">

    </div>
</div>