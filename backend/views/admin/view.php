<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\extensions\CheckRule;
use common\extensions\Util;

$this->title = '查看管理员详情';
$this->params['breadcrumbs'][] = ['label' => '管理员列表', 'url' => ['index']];
?>
<div class="box box-primary">
    <div class="box-header">
        <?php if (CheckRule::checkRole('admin/update')) { ?>
            <div class="pull-left">
                <?= Html::a('修改', ['update', 'id' => $model->c_id], ['class' => 'btn btn-primary']) ?>
            </div>
        <?php } ?>
        <?php if (CheckRule::checkRole('admin/delete')) { ?>
            <div class="pull-right">
                <?=
                Html::a('删除', ['delete', 'id' => $model->c_id], [
                    'class' => 'btn btn-danger',
                    'data' => ['confirm' => '你确认删除吗？', 'method' => 'post'],
                ])
                ?>
            </div>
        <?php } ?>
    </div>
    <div class="box-body">
        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                'c_id',
                'c_mobile',
                'c_admin_name',
                'c_email:email',
                ['label' => $model->getAttributeLabel('c_status'), 'format' => 'raw', 'value' => Util::getStatusIcon($model->c_status)],
                ['label' => $model->getAttributeLabel('c_role_id'), 'value' => isset($model->adminRole->c_title) ? $model->adminRole->c_title : '--'],
                'c_login_total',
                ['label' => $model->getAttributeLabel('c_last_ip'), 'value' => long2ip($model->c_last_ip)],
                ['label' => $model->getAttributeLabel('c_last_login_time'), 'value' => date('Y-m-d H:i:s', $model->c_last_login_time)],
                ['label' => $model->getAttributeLabel('c_create_time'), 'value' => date('Y-m-d H:i:s', $model->c_create_time)],
                'c_update_time',
            ],
        ])
        ?>
    </div>
</div>
