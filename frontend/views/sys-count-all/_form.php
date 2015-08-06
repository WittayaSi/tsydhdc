<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\SysCountAll */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sys-count-all-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'hospcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'month')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'person')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'death')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'service')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'accident')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'diagnosis_opd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'procedure_opd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ncdscreen')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'chronicfu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'labfu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'chronic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'epi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nutrition')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'prenatal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'anc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'labor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'postnatal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'newborn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'newborncare')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dental')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'admission')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'diagnosis_ipd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'procedure_ipd')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
