<?php

use yii\helpers\Html;
use kartik\date\DatePicker;
?>
<?php
$this->title = 'ประชาชนอายุ 35 ปีขึ้นไปได้รับการคัดกรองความดันโลหิต';
$this->params['breadcrumbs'][] = ['label' => 'คัดกรอง', 'url' => ['screen/index']];
$this->params['breadcrumbs'][] = 'ประชาชนอายุ 35 ปีขึ้นไปได้รับการคัดกรองความดันโลหิต';
?>

<div class='well'>
    <div class="row">
        <form method="POST">
        <div class="col-sm-3">

        </div>
        <div class="col-sm-1">
            <h5>คัดกรอง: </h5>
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
</div>
<a href="#" id="btn_sql">ชุดคำสั่ง</a>
<div id="sql" style="display: none"><?= $sql ?></div>
<?php
if (isset($dataProvider))
    //$dev = Html::a('คุณศรศักดิ์ สีหะวงษ์', 'https://fb.com/sosplk', ['target' => '_blank']);


//echo yii\grid\GridView::widget([

$header = '<i class="glyphicon glyphicon-th-list"></i> ประชาชนอายุ 35 ปีขึ้นไปได้รับการคัดกรองความดันโลหิต ';

echo \kartik\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'responsive' => TRUE,
    'hover' => true,
    'floatHeader' => true,
    'panel' => [
        'before' => '',
        'type' => \kartik\grid\GridView::TYPE_SUCCESS,
        //'after' => 'โดย ' . $dev
        'heading' => $header,
    ],
    'columns' => [
        [
            'attribute' => 'hospcode',
            'label'=>'รหัสสถานบริการ'
        ],
        [
            'attribute' => 'hospname',
            'label' => 'สถานบริการ',
            'format' => 'raw',
            'value' => function($model) use($date1,$date2) {
                return Html::a(Html::encode($model['hospname']), [
                            'epi/indiv-report-bcg',
                            'hospcode' => $model['hospcode'],
                            'date1' => $date1,
                            'date2' => $date2
                ]);
            }// end value
                ],
        [
            'attribute' => 'target',
            'label'=>'เป้าหมาย(คน)'
        ],
        [
            'attribute' => 'result',
            'label'=>'ผลงาน(คน)'
        ],
         [
            'class' => '\kartik\grid\FormulaColumn',
            'header' => 'ร้อยละ',
            'value' => function ($model, $key, $index, $widget) {
                $p = compact('model', 'key', 'index');
                // เขียนสูตร
                if ($widget->col(2, $p) > 0) {
                    $persent = $widget->col(3, $p) / $widget->col(2, $p) * 100;
                    $persent = number_format($persent, 2);
                    return $persent;
                }
            }
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




