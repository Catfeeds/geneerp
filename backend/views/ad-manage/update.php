<?php

$this->title = '编辑广告';
$this->params['breadcrumbs'][] = ['label' => '广告列表', 'url' => ['index']];
echo $this->render('_form', ['model' => $model]);
