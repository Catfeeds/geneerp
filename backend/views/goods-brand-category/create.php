<?php

$this->title = '新增品牌类别';
$this->params['breadcrumbs'][] = ['label' => '品牌类别列表', 'url' => ['index']];
echo $this->render('_form', ['model' => $model]);
