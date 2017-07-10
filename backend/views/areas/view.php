<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AdminRoute */

$this->title = $model->c_id;
$this->params['breadcrumbs'][] = ['label' => 'Admin Routes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-route-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->c_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->c_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'c_id',
            'c_title',
            'c_route',
            'c_icon',
            'c_parent_id',
            'c_sort',
            'c_status',
            'c_create_time',
            'c_update_time',
        ],
    ]) ?>

</div>
