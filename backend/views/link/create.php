<?php

$this->title = '新增链接';
$this->params['breadcrumbs'][] = ['label' => '链接列表', 'url' => ['index']];
echo $this->render('_form', ['model' => $model]);
