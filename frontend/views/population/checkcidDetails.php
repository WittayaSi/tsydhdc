<?php
	use yii\helpers\Html;
	use miloschuman\highcharts\Highcharts;
	use kartik\grid\GridView;
    $this->title = 'รายชื่อ';
    $this->params['breadcrumbs'][] = ['label' => 'ประชากร', 'url' => ['population/index']];
    $this->params['breadcrumbs'][] = ['label' => 'เช็คเลข 13 หลัก', 'url' => ['population/checkcid']];
	$this->params['breadcrumbs'][] = 'รายชื่อ';
?>
<?php 
$gridColumn = [
    //['class' => 'yii\grid\SerialColumn'],

    [
        'attribute' => 'HOSPCODE',
        'label' => 'รหัสสถานบริการ'
    ],
    [
        'attribute' => 'CID',
        'label' => 'CID',
        'noWrap' => true
    ],
    [
        'attribute' => 'PID',
        'label' => 'PID'
    ],
    [
        'attribute' => 'FULLNAME',
        'label' => 'ชื่อ - สกุล',
        'value' => function($data){
                    return $data['NAME'].' '.' '.$data['LNAME'];
                }
    ],
    [
        'attribute' => 'NATION',
        'label' => 'NATION'
    ],
    [
        'attribute' => 'TYPEAREA',
        'label' => 'TYPEAREA'
    ],
];
?>

<?php $header = '<i class="glyphicon glyphicon-th-list"></i> รายชื่อที่ข้อมูลผิดพลาด' ?>

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
    //'containerOptions' => ['style'=>'overflow: auto;'],
    'panel' => [
        'type' => GridView::TYPE_INFO,
        'heading' => $header,
    ],
]); 
?>

