<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\SysCountAll */

$this->title = 'Update Sys Count All: ' . ' ' . $model->hospcode;
$this->params['breadcrumbs'][] = ['label' => 'Sys Count Alls', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->hospcode, 'url' => ['view', 'hospcode' => $model->hospcode, 'month' => $model->month]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sys-count-all-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
