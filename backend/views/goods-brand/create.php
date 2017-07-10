<?php

$this->title = '新增品牌';
$this->params['breadcrumbs'][] = ['label' => '品牌列表', 'url' => ['index']];
echo $this->render('_form', ['model' => $model]);
