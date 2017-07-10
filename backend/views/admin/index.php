<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\extensions\Util;
use common\extensions\CheckRule;
use backend\widgets\SearchForm;
use backend\widgets\GridView;
use backend\models\AdminRole;

$this->title = '管理员列表';
$get = Yii::$app->request->get();
$pagesize = isset($get['AdminSearch']['pagesize']) ? $get['AdminSearch']['pagesize'] : '';
$keyword = isset($get['AdminSearch']['keyword']) ? trim($get['AdminSearch']['keyword']) : '';
$status = isset($get['AdminSearch']['status']) ? $get['AdminSearch']['status'] : '';
$role_id = isset($get['AdminSearch']['role_id']) ? $get['AdminSearch']['role_id'] : '';
?>
<div class="box box-primary">
    <div class="box-header">
        <div class="pull-left">
            <?php $form = SearchForm::begin(); ?>
            <?= $form->field($searchModel, 'pagesize')->dropDownList(Util::getPageSize(), ['prompt' => '选择页码', 'value' => $pagesize]) ?>
            <?= $form->field($searchModel, 'status')->dropDownList(Util::getStatusText(), ['prompt' => '选择状态', 'value' => $status]) ?>
            <?= $form->field($searchModel, 'role_id')->dropDownList(AdminRole::getKeyValue(), ['prompt' => '选择角色', 'value' => $role_id]) ?>
            <?= $form->field($searchModel, 'keyword')->textInput(['maxlength' => true, 'placeholder' => '请输入关键词', 'value' => $keyword]) ?>
            <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('重置', Url::to(['index']), ['class' => 'btn btn-default']) ?>
            <?php SearchForm::end(); ?>
        </div>
        <?php if (CheckRule::checkRole('admin/create')) { ?>
            <div class="pull-right">
                <?= Html::a('<i class="glyphicon glyphicon-plus"></i> 新增', Url::to(['create']), ['class' => 'btn btn-success']) ?>
            </div>
        <?php } ?>
    </div>
    <div class="box-body">
        <?php Pjax::begin(); ?> 
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'attribute' => 'c_id',
                    'headerOptions' => ['style' => 'min-width:50px']
                ],
                [
                    'attribute' => 'c_admin_name',
                    'format' => 'raw',
                    'value' => function($model) use($keyword) {
                        return $keyword ? Util::highlight($keyword, $model->c_admin_name) : $model->c_admin_name;
                    }
                ],
                [
                    'attribute' => 'c_mobile',
                    'format' => 'raw',
                    'value' => function($model) use($keyword) {
                        return $keyword ? Util::highlight($keyword, $model->c_mobile) : $model->c_mobile;
                    }
                ],
                [
                    'attribute' => 'c_email',
                    'format' => 'raw',
                    'value' => function($model) use($keyword) {
                        return $keyword ? Util::highlight($keyword, $model->c_email) : $model->c_email;
                    }
                ],
                [
                    'attribute' => 'c_role_id',
                    'value' => function($model) {
                        return isset($model->adminRole->c_title) ? $model->adminRole->c_title : '--';
                    }
                ],
                [
                    'attribute' => 'c_status',
                    'format' => 'raw',
                    'value' => function($model) {
                        return Util::getStatusIcon($model->c_status);
                    },
                ],
                'c_login_total',
                [
                    'attribute' => 'c_last_login_time',
                    'format' => ['date', 'php:Y-m-d H:i:s']
                ],
                [
                    'attribute' => 'c_last_ip',
                    'value' => function($model) {
                        return long2ip($model->c_last_ip);
                    },
                ],
                [
                    'attribute' => 'c_create_time',
                    'format' => ['date', 'php:Y-m-d H:i:s']
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => '管理操作',
                    'template' => '<span class="pr20">{view}</span><span class="pr20">{update}</span><span class="pr20">{update-password}</span><span class="pr20">{delete}</span>',
                    'buttons' => [
                        'update-password' => function ($url, $model, $key) {
                            $options = ['title' => '修改密码', 'aria-label' => '修改密码', 'data-pjax' => '0'];
                            return Html::a('<i class="glyphicon glyphicon-lock"></i>', $url, $options);
                        },
                            ], 'visibleButtons' => [
                                'view' => CheckRule::checkRole('admin/view'),
                                'update' => CheckRule::checkRole('admin/update'),
                                'update-password' => CheckRule::checkRole('admin/update-password'),
                                'delete' => function ($model) {
                                    return CheckRule::checkRole('admin/delete') && !in_array($model->c_id, Yii::$app->params['admin_id']);
                                },
                            ]
                        ],
                    ],
                ]);
                ?>
                <?php Pjax::end(); ?>
    </div>
</div>