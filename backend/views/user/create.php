<?php

$this->title = '新增用户';
$this->params['breadcrumbs'][] = ['label' => '用户列表', 'url' => ['index']];
echo $this->render('_form', ['model' => $model]);
