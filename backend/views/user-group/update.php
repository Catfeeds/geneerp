<?php

$this->title = '编辑用户组';
$this->params['breadcrumbs'][] = ['label' => '用户组列表', 'url' => ['index']];
echo $this->render('_form', ['model' => $model]);
