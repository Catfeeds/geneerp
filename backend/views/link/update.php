<?php

$this->title = '编辑链接';
$this->params['breadcrumbs'][] = ['label' => '链接列表', 'url' => ['index']];
echo $this->render('_form', ['model' => $model]);
