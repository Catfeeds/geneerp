<?php

$this->title = '编辑管理员';
$this->params['breadcrumbs'][] = ['label' => '管理员列表', 'url' => ['index']];
echo $this->render('_form', ['model' => $model]);
