<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\extensions\Util;
use common\models\NotityTemplate;

if ($model->isNewRecord) {
    $model->c_status = 1;
    $model->c_sort = 0;
}
?>
<div class="box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <?= $form->field($model, 'c_type')->dropDownList(NotityTemplate::getType(), ['prompt' => '选择消息类型']) ?>
        <?= $form->field($model, 'c_title')->textInput(['maxlength' => true]) ?>
        <div class="box box-solid box-default">
            <div class="box-header">
                模板设置
            </div>
            <div class="box-body">  
                <?= $form->field($model, 'c_email_status', ['template' => '{input}', 'options' => ['class' => 'form-group col-xs-3']])->checkbox(['label' => '设置邮件模板', 'class' => 'show-hide', 'data-showhide' => 'box-email-template']) ?>
                <?= $form->field($model, 'c_sms_status', ['template' => '{input}', 'options' => ['class' => 'form-group col-xs-3']])->checkbox(['label' => '设置短信模板', 'class' => 'show-hide', 'data-showhide' => 'box-sms-template']) ?>
                <?= $form->field($model, 'c_web_status', ['template' => '{input}', 'options' => ['class' => 'form-group col-xs-3']])->checkbox(['label' => '设置站内信模板', 'class' => 'show-hide', 'data-showhide' => 'box-web-template']) ?>
                <?= $form->field($model, 'c_app_status', ['template' => '{input}', 'options' => ['class' => 'form-group col-xs-3']])->checkbox(['label' => '设置APP推送模板', 'class' => 'show-hide', 'data-showhide' => 'box-app-template']) ?>
            </div>
        </div>
        <div id="box-email-template" class="box box-solid box-default"<?= $model->c_email_status == 1 ? : ' style="display:none"' ?>>
            <div class="box-header">
                <h3 class="box-title">邮件模板设置</h3>
                <div class="pull-right">
                    <label class="label bg-green">${username} = 用户名</label>
                    <label class="label bg-green">${webname} = 网站名称</label>
                    <label class="label bg-green">${website} = 网站地址</label>
                    <label class="label bg-green">${phone} = 客服电话</label>
                    <label class="label bg-green">${weixin} = 微信号</label>
                </div>
            </div>
            <div class="box-body">
                <?= $form->field($model, 'c_email_subject')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'c_email_template')->textArea(['maxlength' => true, 'rows' => 3]) ?>
            </div>
        </div>
        <div id="box-sms-template" class="box box-solid box-default"<?= $model->c_sms_status == 1 ? : ' style="display:none"' ?>>
            <div class="box-header">
                <h3 class="box-title">阿里大于短信设置</h3>
                <div class="pull-right">
                    <label class="label bg-green">${username} = 用户名</label>
                    <label class="label bg-green">${code} = 验证码</label>
                </div>
            </div>
            <div class="box-body">
                <?= $form->field($model, 'c_sms_sign_name')->textInput(['maxlength' => true, 'value' => $model->isNewRecord ? Yii::$app->params['sms_sign_name'] : $model->c_sms_sign_name]) ?>
                <?= $form->field($model, 'c_sms_template_code')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'c_sms_template')->textArea(['maxlength' => true, 'rows' => 3]) ?>
            </div>
        </div>
        <div id="box-web-template" class="box box-solid box-default"<?= $model->c_web_status == 1 ? : ' style="display:none"' ?>>
            <div class="box-header">
                <h3 class="box-title">站内信模板设置</h3>
                <div class="pull-right">
                    <label class="label bg-green">${username} = 用户名</label>
                    <label class="label bg-green">${webname} = 网站名称</label>
                    <label class="label bg-green">${website} = 网站地址</label>
                    <label class="label bg-green">${phone} = 客服电话</label>
                    <label class="label bg-green">${weixin} = 微信号</label>
                </div>
            </div>
            <div class="box-body">
                <?= $form->field($model, 'c_web_subject')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'c_web_template')->textArea(['maxlength' => true, 'rows' => 3]) ?>
            </div>
        </div>

        <div id="box-app-template" class="box box-solid box-default"<?= $model->c_app_status == 1 ? : ' style="display:none"' ?>>
            <div class="box-header">
                <h3 class="box-title">APP推送模板设置</h3>
                <div class="pull-right">
                    <label class="label bg-green">${username} = 用户名</label>
                    <label class="label bg-green">${webname} = 网站名称</label>
                    <label class="label bg-green">${website} = 网站地址</label>
                    <label class="label bg-green">${phone} = 客服电话</label>
                    <label class="label bg-green">${weixin} = 微信号</label>
                </div>
            </div>
            <div class="box-body">
                <?= $form->field($model, 'c_app_template')->textArea(['maxlength' => true, 'rows' => 3]) ?>
            </div>
        </div>
        <?= $form->field($model, 'c_sort')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_status')->radioList(Util::getStatusText()) ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '编辑', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>