<?php
	use yii\helpers\Html;
	use miloschuman\highcharts\Highcharts;
	use kartik\grid\GridView;
    $this->title = 'ตรวจเช็คเลข 13 หลัก';
    $this->params['breadcrumbs'][] = ['label' => 'ประชากร', 'url' => ['population/index']];
	$this->params['breadcrumbs'][] = 'เช็คเลข 13 หลัก';
?>
<?php 
$gridColumn = [
    //['class' => 'yii\grid\SerialColumn'],

    [
        'attribute' => 'hospcode',
        'label' => 'รหัสสถานบริการ'
    ],
    [
        'attribute' => 'hosname',
        'label' => 'ชื่อสถานบริการ',
        'format' => 'raw',
        'value' => function($model){
                if($model['no_of_error'] > 0){
                    return Html::a(Html::encode($model['hosname']), [
                            'population/checkcid-details',
                            'hospcode' => $model['hospcode'],
                
                    ]);
                }
                else return $model['hosname'];
        },
        'noWrap' => true
    ],
    [
        'attribute' => 'no_of_persons',
        'label' => 'จำนวนประชากร'
    ],
    [
        'attribute' => 'no_of_error',
        'label' => 'จำนวนที่ผิด'
    ],
    [
        'attribute' => 'percent_of_complete',
        'label' => '% ความถูกต้อง'
    ]
];
?>

<?php $header = '<i class="glyphicon glyphicon-th-list"></i> ความถูกต้องของ CID '?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'pjax' => true,
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
    'rowOptions' => function($model){
        if($model['percent_of_complete'] >= '95'){
            return ['class' => 'success'];
        }else if($model['percent_of_complete'] >= '90'){
            return ['class' => 'warning'];
        }else{
            return ['class' => 'danger'];
        }
    },
    'columns' => $gridColumn,
    'containerOptions' => ['style'=>'overflow: auto;'],
    'panel' => [
        'type' => GridView::TYPE_INFO,
        'heading' => $header,
    ],
]); 
?>

