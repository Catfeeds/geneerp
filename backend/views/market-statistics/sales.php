<?php

use yii\helpers\Url;
use yii\helpers\Html;
use backend\widgets\SearchForm;

common\assets\EchartsAsset::register($this);
$this->title = '人均消费统计';
$get = Yii::$app->request->get();
$start_time = isset($get['StatisticsSearch']['start_time']) ? $get['StatisticsSearch']['start_time'] : '';
$end_time = isset($get['StatisticsSearch']['end_time']) ? $get['StatisticsSearch']['end_time'] : '';
?>
<div class="box box-primary">
    <div class="box-header">
        <?php $form = SearchForm::begin(); ?>
        <?= $form->field($searchModel, 'start_time')->textInput(['maxlength' => true, 'value' => $start_time, 'class' => 'form-control form-date']) ?>
        <?= $form->field($searchModel, 'end_time')->textInput(['maxlength' => true, 'value' => $end_time, 'class' => 'form-control form-date']) ?>
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('重置', Url::to(['sales']), ['class' => 'btn btn-default']) ?>
        <?php SearchForm::end(); ?>
    </div>
    <div class="box-body">
        <div id="main" style="width:100%;height:400px;"></div>
    </div>
</div>
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main'));

    // 指定图表的配置项和数据
    var option = {
        title: {text: '人均消费统计'},
        tooltip: {show: true},
        toolbox: {left: 'right', feature: {dataZoom: {yAxisIndex: 'none'}, restore: {}, saveAsImage: {}}},
        xAxis: {data: <?= $key ?>},
        yAxis: {name: '金额(元)'},
        series: [{name: '消费金额', type: 'line', data:<?= $value ?>}]
    };
    myChart.setOption(option);
</script>