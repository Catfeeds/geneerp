<?php

$this->title = '编辑消息模板';
$this->params['breadcrumbs'][] = ['label' => '消息模板列表', 'url' => ['index']];
echo $this->render('_form', ['model' => $model]);
