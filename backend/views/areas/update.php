<?php

$this->title = '编辑地区';
$this->params['breadcrumbs'][] = ['label' => '地区列表', 'url' => ['index']];
echo $this->render('_form', ['model' => $model]);