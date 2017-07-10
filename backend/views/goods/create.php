<?php

$this->title = '新增商品';
$this->params['breadcrumbs'][] = ['label' => '商品列表', 'url' => ['index']];
echo $this->render('_form', ['model' => $model]);
