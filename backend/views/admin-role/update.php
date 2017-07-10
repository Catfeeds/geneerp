<?php

$this->title = '编辑角色';
$this->params['breadcrumbs'][] = ['label' => '角色列表', 'url' => ['index']];
echo $this->render('_form', ['model' => $model]);
