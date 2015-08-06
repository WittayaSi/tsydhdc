<?php
	use yii\helpers\Html;
	use miloschuman\highcharts\Highcharts;
	use kartik\grid\GridView;
    $this->title = 'ประเภทการอยู่อาศัย';
    $this->params['breadcrumbs'][] = ['label' => 'ประชากร', 'url' => ['population/index']];
	$this->params['breadcrumbs'][] = 'ประเภทการอยู่อาศัย';
?>
<?php 
$gridColumn = [
    //['class' => 'yii\grid\SerialColumn'],

    [
        'attribute' => 'HOSPCODE',
        'label' => 'รหัสสถานบริการ'
    ],
    [
        'attribute' => 'HOSPNAME',
        'label' => 'ชื่อสถานบริการ',
        'noWrap' => true
    ],
    [
        'attribute' => 'THAI',
        'label' => 'คนไทย'
    ],
    [
        'attribute' => 'TYPE1',
        'label' => 'TYPE1'
    ],
    [
        'attribute' => 'TYPE2',
        'label' => 'TYPE2'
    ],
    [
        'attribute' => 'TYPE3',
        'label' => 'TYPE3'
    ],
    [
        'attribute' => 'TYPE4',
        'label' => 'TYPE4'
    ],
    [
        'attribute' => 'NOT_THAI',
        'label' => 'ต่างด้าว'
    ],
    [
        'attribute' => 'NOT_THAI_TYPE1',
        'label' => 'TYPE1'
    ],
    [
        'attribute' => 'NOT_THAI_TYPE2',
        'label' => 'TYPE2'
    ],
    [
        'attribute' => 'NOT_THAI_TYPE3',
        'label' => 'TYPE3'
    ],
    [
        'attribute' => 'NOT_THAI_TYPE4',
        'label' => 'TYPE4'
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

