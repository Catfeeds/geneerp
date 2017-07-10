<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use common\models\Feedback;
use common\models\UserProfile;

$this->title = '处理反馈';
$this->params['breadcrumbs'][] = ['label' => '反馈列表', 'url' => ['index']];
?>
<div class="box box-primary">
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
                'c_note',
                ['label' => $model->getAttributeLabel('c_status'), 'value' => Feedback::getStatus($model->c_status)],
                ['label' => $model->getAttributeLabel('c_create_time'), 'value' => date('Y-m-d H:i:s', $model->c_create_time)],
                'c_update_time',
            ],
        ])
        ?>
    </div>
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <?= $form->field($model, 'c_status')->radioList(Feedback::getStatus()) ?>
        <?= $form->field($model, 'reply_content')->textArea(['maxlength' => true, 'rows' => 3, 'value' => isset($model->feedbackText) ? $model->feedbackText->c_reply_content : '']) ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton('回复反馈', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
