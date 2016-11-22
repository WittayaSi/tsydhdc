<?php

use yii\helpers\Html;
use miloschuman\highcharts\Highcharts;
use kartik\grid\GridView;
use kartik\date\DatePicker;
use yii\data\ArrayDataProvider;

$this->title = 'เป้าหมายพัฒนาการ';
$this->params['breadcrumbs'][] = ['label' => 'ประชากร', 'url' => ['population/index']];
$this->params['breadcrumbs'][] = 'เป้าหมายพัฒนาการ';
?>
<div class='well'>
    <form method="POST">
        <div class="col-sm-2">
            <h5>ช่วงวันเกิด : </h5>
        </div>
        <div class="col-sm-4">
            <?php
            echo DatePicker::widget([
                'type' => DatePicker::TYPE_RANGE,
                'name' => 'date1',
                'value' => $date1,
                'name2' => 'date2',
                'value2' => $date2,
                'separator' => '<i class="glyphicon glyphicon-resize-horizontal"></i>',
                'addon' => [
                    'part1' => '<span class="input-group-addon">From Date</span>',
                    'part2' => '<span class="input-group-addon">aft</span>',
                    'part3' => '<span class="input-group-addon">To Date</span>',
                    'part4' => '<span class="input-group-addon kv-date-remove">'
                    . '<i class="glyphicon glyphicon-remove"></i></span>',
                ],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]);
            ?>
        </div>
        <button class='btn btn-danger'>ประมวลผล</button>
    </form>
</div>

<?php
if (!count($rawData) > 0) {
    throw new \yii\web\ConflictHttpException("ไม่มีข้อมูล");
}

function filter($col) {
    $filterresult = Yii::$app->request->getQueryParam('filterresult', '');
    if (strlen($filterresult) > 0) {
        if (strpos($col['result'], $filterresult) !== false) {
            return true;
        } else {
            return false;
        }
    } else {
        return true;
    }
}

$filteredData = array_filter($rawData, 'filter');
$searchModel = ['result' => Yii::$app->request->getQueryParam('$filterresult', '')];

$dataProvider = new ArrayDataProvider([
    'allModels' => $filteredData,
    'pagination' => false,
    'sort' => [
        'attributes' => ['HOSPCODE' => ['default' => SORT_DESC],'BIRTH' => ['default' => SORT_DESC]]
    ]
]);


echo \kartik\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'responsive' => TRUE,
    'hover' => true,
    'floatHeader' => true,
    'panel' => [
        'before' => '',
        'type' => \kartik\grid\GridView::TYPE_SUCCESS,
    //'after' => 'โดย ' . $dev
    ],
    'columns' => [
        [
            'attribute' => 'HOSPCODE',
            'label' => 'รหัสสถานบริการ',
            'hAlign' => 'center',
            'vAlign' => 'middle'
        ],
        [
            'attribute' => 'CID',
            'header' => 'เลขบัตรประจำตัวประชาชน',
            'hAlign' => 'center',
            'vAlign' => 'middle'
        ],
        [
            'attribute' => 'PID',
            'hAlign' => 'center',
            'vAlign' => 'middle'
        ],
        [
            'header' => 'ชื่อ - สกุล',
            'format' => 'raw',
            'value' => function($model) {
                return $model['NAME'] . ' ' . $model['LNAME'];
            }, // end value
            'hAlign' => 'left',
            'vAlign' => 'middle',
            'noWrap' => true
        ],
        [
            'header' => 'เพศ',
            'format' => 'raw',
            'value' => function($model) {
                if ($model['SEX'] == 1) {
                    return 'ชาย';
                } else {
                    return 'หญิง';
                }
            }, // end value
            'hAlign' => 'center',
            'vAlign' => 'middle',
            'noWrap' => true
        ],
        [
            'attribute' => 'BIRTH',
            'hAlign' => 'center',
            'vAlign' => 'middle',
            'noWrap' => true
        ]
    ]
]);
?>

<?php
$script = <<< JS
$(function(){
    $("label[title='Show all data']").hide();
});
        
$('#btn_sql').on('click', function(e) {
    
   $('#sql').toggle();
});
JS;
$this->registerJs($script);
?>

