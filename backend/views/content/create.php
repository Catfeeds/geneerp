<?php

$this->title = '新增内容';
$this->params['breadcrumbs'][] = ['label' => '内容列表', 'url' => ['index']];
echo $this->render('_form', ['model' => $model]);
