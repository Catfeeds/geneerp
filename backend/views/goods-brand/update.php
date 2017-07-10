<?php

$this->title = '编辑品牌';
$this->params['breadcrumbs'][] = ['label' => '品牌列表', 'url' => ['index']];
echo $this->render('_form', ['model' => $model]);
