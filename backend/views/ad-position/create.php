<?php

$this->title = '新增广告位';
$this->params['breadcrumbs'][] = ['label' => '广告位列表', 'url' => ['index']];
echo $this->render('_form', ['model' => $model]);
