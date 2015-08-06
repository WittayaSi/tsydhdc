<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model frontend\models\SysCountAll */

$this->title = $model->hospcode;
$this->params['breadcrumbs'][] = ['label' => 'Sys Count Alls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-count-all-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- <p>
        <?= Html::a('Update', ['update', 'hospcode' => $model->hospcode, 'month' => $model->month], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'hospcode' => $model->hospcode, 'month' => $model->month], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p> -->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'hospcode',
                'format' => 'raw',
                'value' => function($model) {
                    return $model['hospcode'];
                }
            ],
            'month',
            'person',
            'death',
            'service',
            'accident',
            'diagnosis_opd',
            'procedure_opd',
            'ncdscreen',
            'chronicfu',
            'labfu',
            'chronic',
            'fp',
            'epi',
            'nutrition',
            'prenatal',
            'anc',
            'labor',
            'postnatal',
            'newborn',
            'newborncare',
            'dental',
            'admission',
            'diagnosis_ipd',
            'procedure_ipd',
        ],
    ]) ?>

</div>
