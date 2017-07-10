<?php

$this->title = '编辑自提点';
$this->params['breadcrumbs'][] = ['label' => '自提点列表', 'url' => ['index']];
echo $this->render('_form', ['model' => $model]);