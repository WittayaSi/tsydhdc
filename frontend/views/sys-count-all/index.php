<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use frontend\models\ChospitalAmp;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SysCountAllSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sys Count Alls';
$this->params['breadcrumbs'][] = $this->title;
$year1 = '2558';
?>
<div class="syscountall-index">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        
    <!-- <p>
        <?= Html::a('Create Sys Count All', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    -->

    <div class="lead alert alert-success">
        <div class="row">
            <div class="col-lg-4">
            </div>
            <div class="col-lg-4" style="text-align: center;">
                <p>ปีงบประมาณ</p>
                <form method="POST">
                    <p>
                    <?php
                        $list = ['2558'=>'2558','2557'=>'2557','2556'=>'2556'];
                        echo yii\helpers\Html::dropDownList('fyscalyear',$year, $list, [
                            'prompt' => 'เลือกปีงบประมาณ',
                            'class' => 'form-control'
                        ]);
                        if(!empty($year)){
                            $year1 = $year;
                        }
                        ?>
                    </p>
                    <p>
                    <div>
                        <button class = 'btn btn-success'>Search</button>
                    </div>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <?php 
        $gridColumn = [
            //['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'รหัส',
                'format' => 'raw',
                'value' => function($model) {
                    $hospcode = $model['hospcode'];
                    return Html::a(Html::encode($hospcode), ['sys-count-all/view', 'id' => $hospcode]);
                }
            ],

            [
                'class' => '\kartik\grid\DataColumn',
                'attribute' => 'ชื่อสถานบริการ',
                'value' => 'hospname',
                'vAlign'=>'middle',
                'noWrap'=>true,
            ],
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
        ];
    ?>

    <?php $header = '<i class="glyphicon glyphicon-th-list"></i>  ข้อมูลปีงบประมาณ '.$year1;?>

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
        'columns' => $gridColumn,
        'containerOptions' => ['style'=>'overflow: auto;'],
        'panel' => [
            'type' => GridView::TYPE_INFO,
            'heading' => $header,
        ],
    ]); ?>

</div>
