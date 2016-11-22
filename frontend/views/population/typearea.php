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
        'attribute' => 'hospcode',
        'label' => 'รหัสสถานบริการ',
        'noWrap' => true
    ],
    [
        'attribute' => 'hospname',
        'label' => 'ชื่อสถานบริการ',
        'noWrap' => true
    ],
    [
        'attribute' => 'type1',
        'label' => 'TYPE1',
        'noWrap' => true
    ],
    [
        'attribute' => 'type2',
        'label' => 'TYPE2',
        'noWrap' => true
    ],
    [
        'attribute' => 'type3',
        'label' => 'TYPE3',
        'noWrap' => true
    ],
    [
        'attribute' => 'type4',
        'label' => 'TYPE4',
        'noWrap' => true
    ],
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

