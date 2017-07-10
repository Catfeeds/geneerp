<?php

$this->title = '编辑内容类别';
$this->params['breadcrumbs'][] = ['label' => '内容类别列表', 'url' => ['index']];
echo $this->render('_form', ['model' => $model]);
