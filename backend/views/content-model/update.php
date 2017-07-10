<?php

$this->title = '编辑内容模型';
$this->params['breadcrumbs'][] = ['label' => '内容模型列表', 'url' => ['index']];
echo $this->render('_form', ['model' => $model]);
