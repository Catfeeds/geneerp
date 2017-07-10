<?php

$this->title = '编辑品牌类别';
$this->params['breadcrumbs'][] = ['label' => '品牌类别列表', 'url' => ['index']];
echo $this->render('_form', ['model' => $model]);