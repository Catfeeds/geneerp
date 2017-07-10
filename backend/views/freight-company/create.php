<?php

$this->title = '新增物流公司';
$this->params['breadcrumbs'][] = ['label' => '物流公司列表', 'url' => ['index']];
echo $this->render('_form', ['model' => $model]);
