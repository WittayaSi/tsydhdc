<?php
	use yii\helpers\Html;
	use miloschuman\highcharts\Highcharts;
	use kartik\grid\GridView;
    $this->title = 'ประเภทการอยู่อาศัยที่ซ้ำซ้อน';
    $this->params['breadcrumbs'][] = ['label' => 'ประชากร', 'url' => ['population/index']];
	$this->params['breadcrumbs'][] = 'ประเภทการอยู่อาศัยที่ซ้ำซ้อน';
?>
<?php 
$gridColumn = [
    //['class' => 'yii\grid\SerialColumn'],

    [
        'attribute' => 'cid',
        'label' => 'เลขประชาชน',
        'hAlign' => 'center',
        'vAlign' => 'middle'
    ],
    [
        'attribute' => 'fullname',
        'label' => 'ชื่อ - สกุล',
        'noWrap' => true
    ],
    [
        'attribute' => 'typearea',
        'label' => 'ประเภทพักอาศัย',
        'noWrap' => true,
        'hAlign' => 'center',
        'vAlign' => 'middle'
    ],
    [
        'attribute' => 'his',
        'label' => 'เลขประจำตัว',
        'noWrap' => true,
        'hAlign' => 'center',
        'vAlign' => 'middle'
    ],
    [
        'attribute' => 'birth',
        'label' => 'วันเกิด',
        'noWrap' => true,
        'hAlign' => 'center',
        'vAlign' => 'middle'
    ],
    [
        'attribute' => 'hospcode',
        'label' => 'รหัสหน่วยบริการ',
        'noWrap' => true,
        'hAlign' => 'center',
        'vAlign' => 'middle'
    ]
];
?>

<?php $header = '<i class="glyphicon glyphicon-th-list"></i> ประชากรแยกตามประเภทการอยู่อาศัย '?>

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
    'columns' => $gridColumn,
    'containerOptions' => ['style'=>'overflow: auto;'],
    'panel' => [
        'type' => GridView::TYPE_INFO,
        'heading' => $header,
    ],
]); 
?>

