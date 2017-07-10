<?php

$this->title = '新增商品类别';
$this->params['breadcrumbs'][] = ['label' => '商品类别列表', 'url' => ['index']];
echo $this->render('_form', ['model' => $model]);
