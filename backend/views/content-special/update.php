<?php

$this->title = '编辑内容专题';
$this->params['breadcrumbs'][] = ['label' => '内容专题列表', 'url' => ['index']];
echo $this->render('_form', ['model' => $model]);
