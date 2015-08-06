<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\SysCountAllSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sys-count-all-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'hospcode') ?>

    <?= $form->field($model, 'month') ?>

    <?= $form->field($model, 'person') ?>

    <?= $form->field($model, 'death') ?>

    <?= $form->field($model, 'service') ?>

    <?php // echo $form->field($model, 'accident') ?>

    <?php // echo $form->field($model, 'diagnosis_opd') ?>

    <?php // echo $form->field($model, 'procedure_opd') ?>

    <?php // echo $form->field($model, 'ncdscreen') ?>

    <?php // echo $form->field($model, 'chronicfu') ?>

    <?php // echo $form->field($model, 'labfu') ?>

    <?php // echo $form->field($model, 'chronic') ?>

    <?php // echo $form->field($model, 'fp') ?>

    <?php // echo $form->field($model, 'epi') ?>

    <?php // echo $form->field($model, 'nutrition') ?>

    <?php // echo $form->field($model, 'prenatal') ?>

    <?php // echo $form->field($model, 'anc') ?>

    <?php // echo $form->field($model, 'labor') ?>

    <?php // echo $form->field($model, 'postnatal') ?>

    <?php // echo $form->field($model, 'newborn') ?>

    <?php // echo $form->field($model, 'newborncare') ?>

    <?php // echo $form->field($model, 'dental') ?>

    <?php // echo $form->field($model, 'admission') ?>

    <?php // echo $form->field($model, 'diagnosis_ipd') ?>

    <?php // echo $form->field($model, 'procedure_ipd') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
