<?php

$this->title = '编辑广告位';
$this->params['breadcrumbs'][] = ['label' => '广告位列表', 'url' => ['index']];
echo $this->render('_form', ['model' => $model]);
