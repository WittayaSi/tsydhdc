<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\SysCountAll */

$this->title = 'Create Sys Count All';
$this->params['breadcrumbs'][] = ['label' => 'Sys Count Alls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-count-all-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
