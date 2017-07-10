<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\UserAcountLog;

$this->title = '用户账户管理';
$this->params['breadcrumbs'][] = ['label' => '用户列表', 'url' => ['index']];
?>
<div class="box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($acount, 'user_id')->hiddenInput(['value' => $model->c_user_id])->label(false); ?>
    <div class="box-body">
        <div class="row">
            <div class="form-group col-xs-2">
                <label class="control-label"><?= $model->user->c_user_name ?></label>
            </div>
            <div class="form-group col-xs-2">
                <label class="control-label">现金账户金额</label> <?= $model->c_amount ?>
            </div>
            <div class="form-group col-xs-2">
                <label class="control-label">冻结账户金额</label> <?= $model->c_frozen_amount ?>
            </div>
            <div class="form-group col-xs-2">
                <label class="control-label">用户积分</label> <?= $model->c_point ?>
            </div>
            <div class="form-group col-xs-2">
                <label class="control-label">用户经验值</label> <?= $model->c_exp ?>
            </div>
        </div>
        <div class="row">
            <?= $form->field($acount, 'type', ['options' => ['class' => 'form-group col-xs-2']])->dropDownList(UserAcountLog::getType(), ['prompt' => '选择类型']) ?>
            <?= $form->field($acount, 'amount', ['options' => ['class' => 'form-group col-xs-2']])->textInput(['maxlength' => true]) ?>   
            <?= $form->field($acount, 'frozen_amount', ['options' => ['class' => 'form-group col-xs-2']])->textInput(['maxlength' => true]) ?>   
            <?= $form->field($acount, 'point', ['options' => ['class' => 'form-group col-xs-2']])->textInput(['maxlength' => true]) ?>   
            <?= $form->field($acount, 'exp', ['options' => ['class' => 'form-group col-xs-2']])->textInput(['maxlength' => true]) ?>   
        </div>
    </div>
    <div class="box-footer">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>