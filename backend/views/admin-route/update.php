<?php

$this->title = '编辑路由';
$this->params['breadcrumbs'][] = ['label' => '路由列表', 'url' => ['index']];
echo $this->render('_form', ['model' => $model]);