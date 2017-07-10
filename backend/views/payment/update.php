<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\extensions\Util;
use common\models\Payment;

$this->title = '编辑支付方式';
$this->params['breadcrumbs'][] = ['label' => '支付方式列表', 'url' => ['index']];
?>
<div class="box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <?= $form->field($model, 'c_title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_description')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_poundage_type')->radioList(Payment::getPoundageType()) ?>
        <?= $form->field($model, 'c_poundage')->textInput(['maxlength' => true])->label('商品总额的百分比') ?>
        <?= $form->field($model, 'c_client_type')->radioList(Payment::getClientType()) ?>
        <?= $form->field($model, 'c_content')->textArea(['maxlength' => true, 'rows' => 3]) ?>
        <?= $form->field($model, 'c_sort')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'c_status')->radioList(Util::getStatusText()) ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '编辑', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
$js = <<<EOT
    function setPoundage(type) {
        if (type === '1') {
            $('.field-payment-c_poundage label').text('商品总额的百分比');
        } else {
            $('.field-payment-c_poundage label').text('固定收取的手续费');
        }
    }
    $(function () {
        setPoundage('$model->c_poundage_type');
        $('#payment-c_poundage_type input').on('click', function () {
            setPoundage($(this).val());
        });
    });
EOT;
backend\assets\AppAsset::addScript($js);
?>  
