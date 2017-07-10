<?php

$this->title = '新增地区';
$this->params['breadcrumbs'][] = ['label' => '地区列表', 'url' => ['index']];
echo $this->render('_form', ['model' => $model]);
