<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\extensions\Util;
use common\extensions\CheckRule;
use common\models\Content;
use common\models\ContentSpecial;
use common\models\ContentCategory;
use common\models\Upload;
use backend\widgets\GridView;
use backend\widgets\SearchForm;

$this->title = '内容列表';
$get = Yii::$app->request->get();
$pagesize = isset($get['ContentSearch']['pagesize']) ? $get['ContentSearch']['pagesize'] : '';
$keyword = isset($get['ContentSearch']['keyword']) ? trim($get['ContentSearch']['keyword']) : '';
$status = isset($get['ContentSearch']['status']) ? $get['ContentSearch']['status'] : '';
$category_id = isset($get['ContentSearch']['category_id']) ? $get['ContentSearch']['category_id'] : '';
$special_id = isset($get['ContentSearch']['special_id']) ? $get['ContentSearch']['special_id'] : '';
$label_id = isset($get['ContentSearch']['label_id']) ? $get['ContentSearch']['label_id'] : '';
?>
<div class="box box-primary">
    <div class="box-header">
        <div class="pull-left">
            <?php $form = SearchForm::begin(); ?>
            <?= $form->field($searchModel, 'pagesize')->dropDownList(Util::getPageSize(), ['prompt' => '选择页码', 'value' => $pagesize]) ?>
            <?= $form->field($searchModel, 'status')->dropDownList(Content::getStatus(), ['prompt' => '选择状态', 'value' => $status]) ?>
            <?= $form->field($searchModel, 'category_id')->dropDownList(ContentCategory::formatDropDownListCache(), ['prompt' => '选择类别', 'value' => $category_id]) ?>
            <?= $form->field($searchModel, 'special_id')->dropDownList(ContentSpecial::formatDropDownListCache(), ['prompt' => '选择专题', 'value' => $special_id]) ?>
            <?= $form->field($searchModel, 'label_id')->dropDownList(Content::getLabel(), ['prompt' => '选择标签', 'value' => $label_id]) ?>
            <?= $form->field($searchModel, 'keyword')->textInput(['maxlength' => true, 'placeholder' => '请输入关键词', 'value' => $keyword]) ?>
            <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('重置', Url::to(['index']), ['class' => 'btn btn-default']) ?>
            <?php SearchForm::end(); ?>
        </div>
        <?php if (CheckRule::checkRole('content/create')) { ?>
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
                'c_sort',
                [
                    'attribute' => 'c_title',
                    'format' => 'raw',
                    'value' => function($model) use($keyword) {
                        return $keyword ? Util::highlight($keyword, $model->c_title) : $model->c_title;
                    }
                ],
                [
                    'attribute' => 'c_picture',
                    'format' => ['image', ['height' => 50]],
                    'value' => function ($model) {
                return Upload::getThumbOne($model->c_picture, true);
            }
                ],
                [
                    'attribute' => 'c_category_id',
                    'format' => 'raw',
                    'value' => function($model) {
                        return isset($model->contentCategory->c_title) ? $model->contentCategory->c_title : '--';
                    },
                ],
                [
                    'attribute' => 'c_special_id',
                    'format' => 'raw',
                    'value' => function($model) {
                        return isset($model->contentSpecial->c_title) ? $model->contentSpecial->c_title : '--';
                    },
                ],
                [
                    'label' => '标签',
                    'attribute' => 'label',
                    'format' => 'raw',
                    'value' => function($model) {
                        $label_array = [];
                        if (isset($model->contentLabel)) {
                            foreach ($model->contentLabel as $label) {
                                $label_array[] = $label->c_type;
                            }
                        }
                        return Content::getLabelHtml($label_array);
                    },
                        ],
                        [
                            'attribute' => 'c_status',
                            'format' => 'raw',
                            'value' => function($model) {
                                return Content::getStatus($model->c_status);
                            },
                        ],
                        [
                            'attribute' => 'c_create_time',
                            'format' => ['date', 'php:Y-m-d H:i:s']
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => '管理操作',
                            'template' => '<span class="pr20">{update}</span><span class="pr20">{delete}</span>',
                            'visibleButtons' => [
                                'update' => CheckRule::checkRole('content/update'),
                                'delete' => CheckRule::checkRole('content/delete')
                            ]
                        ],
                    ],
                ]);
                ?>
                <?php Pjax::end(); ?>
    </div>
</div>