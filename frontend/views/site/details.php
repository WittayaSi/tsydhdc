<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model frontend\models\SysCountAll */
$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-count-all-view">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <h1> Target </h1>
    <?php
        $gridColumns_target = [
            //['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'HOSPCODE',
                'value' => 'HOSPCODE',
            ],
            [
                'attribute' => 'CID',
                'value' => 'CID',
            ],
            [
                'attribute' => 'PID',
                'value' => 'PID',
            ],
            [
                'attribute' => 'Full Name',
                'value' => function($data){
                    return $data['NAME'].' '.' '.$data['LNAME'];
                },
                'noWrap' => true
            ],
            'HN',
            [
                'attribute' => 'SEX',
                'value' =>function($data){
                    if($data['SEX'] == 1){
                        return 'ชาย';
                    }else{
                        return 'หญิง';
                    }
                },
                'noWrap' => true
            ],
            [
                'attribute' => 'BIRTH',
                'value' => 'BIRTH',
                'noWrap' => true
            ],

        ];
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'pjax' => true,
        'pjaxSettings' => [
            //'neverTimeout' => true,
            'options' => [
                'enablePushState' => false,
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'panel' => [
            'before' => '',
        //'after'=>''
        ],
        'columns' => $gridColumns_target,
    ]) ?>

    <?php 
    $gridColumns_result = [
            'HOSPCODE',
            'CID',
            'PID',
            [
                'attribute' => 'Full Name',
                'value' => function($data){
                    return $data['NAME'].' '.' '.$data['LNAME'];
                },
                'noWrap' => true
            ],
            'HN',
            [
                'attribute' => 'SEX',
                'value' =>function($data){
                    if($data['SEX'] == 1){
                        return 'ชาย';
                    }else{
                        return 'หญิง';
                    }
                },
                'noWrap' => true
            ],
            [
                'attribute' => 'BIRTH',
                'value' => 'BIRTH',
                'noWrap' => true
            ],
        ];
    ?>

    <h1> Result </h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider1,
        'pjax' => true,
        'pjaxSettings' => [
            //'neverTimeout' => true,
            'options' => [
                'enablePushState' => false,
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'panel' => [
            'before' => '',
        //'after'=>''
        ],
        'columns' => $gridColumns_result,
    ]) ?>

</div>
