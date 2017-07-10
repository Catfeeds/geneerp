<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\extensions\CheckRule;
use common\models\Feedback;
use common\models\UserProfile;

$this->title = '查看反馈';
$this->params['breadcrumbs'][] = ['label' => '反馈列表', 'url' => ['index']];
?>
<div class="box box-primary">
    <div class="box-header">
        <?php if (CheckRule::checkRole('feedback/operation')) { ?>
            <div class="pull-left">
                <?= Html::a('处理', ['operation', 'id' => $model->c_id], ['class' => 'btn btn-primary']) ?>
            </div>
        <?php } ?>
    </div>
    <div class="box-body">
        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                'c_id',
                'c_user_name',
                ['label' => $model->getAttributeLabel('c_sex'), 'value' => UserProfile::getSex($model->c_sex)],
                'c_mobile',
                'c_phone',
                'c_email',
                'c_title',
                ['label' => $model->getAttributeLabel('content'), 'value' => isset($model->feedbackText) ? $model->feedbackText->c_content : '--'],
                ['label' => $model->getAttributeLabel('reply_content'), 'value' => isset($model->feedbackText->c_reply_content) ? $model->feedbackText->c_reply_content : '--'],
                'c_note',
                ['label' => $model->getAttributeLabel('c_status'), 'value' => Feedback::getStatus($model->c_status)],
                ['label' => $model->getAttributeLabel('c_create_time'), 'value' => date('Y-m-d H:i:s', $model->c_create_time)],
                'c_update_time',
            ],
        ])
        ?>
    </div>
</div>
