<?php

$this->title = '编辑商品模型';
$this->params['breadcrumbs'][] = ['label' => '商品模型列表', 'url' => ['index']];
echo $this->render('_form', ['model' => $model]);
