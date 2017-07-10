<?php

$this->title = '编辑配送方式';
$this->params['breadcrumbs'][] = ['label' => '配送方式列表', 'url' => ['index']];
echo $this->render('_form', ['model' => $model]);