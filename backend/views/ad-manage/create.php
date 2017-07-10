<?php

$this->title = '新增广告';
$this->params['breadcrumbs'][] = ['label' => '广告列表', 'url' => ['index']];
echo $this->render('_form', ['model' => $model]);
