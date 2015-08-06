<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
//use kartik\widgets\ActiveForm; // or 
use yii\widgets\ActiveForm;
use yii\widgets\FileInput;
//use kartik\widgets\FileInput;

//use kartik\widgets\ActiveForm; // or yii\widgets\ActiveForm
//use kartik

/* @var $this yii\web\View */
/* @var $model frontend\models\UploadFortythree */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="upload-fortythree-form">
        <?php
        $form = ActiveForm::begin([
                    'options' => ['enctype' => 'multipart/form-data'] // important
        ]);
        ?>
        <?= $form->field($model, 'file')->fileInput() ?>
        <?php
        /*
          echo $form->field($model, 'file')->widget(FileInput::classname(), [
          'options' => ['accept' => '*'],
          'pluginOptions' => ['allowedFileExtensions' => ['zip']]
          ]); */
        ?>

        <?= $form->field($model, 'upload_date')->hiddenInput(['value' => date('Ymd')])->label(false) ?>
        <?= $form->field($model, 'upload_time')->hiddenInput(['value' => date('His')])->label(false) ?>
        <button class="btn btn-primary"><i class="glyphicon glyphicon-upload"></i> Upload</button>
        <?php ActiveForm::end(); ?>

</div>
