<?php

$this->title = '编辑内容';
$this->params['breadcrumbs'][] = ['label' => '内容列表', 'url' => ['index']];
echo $this->render('_form', ['model' => $model]);
