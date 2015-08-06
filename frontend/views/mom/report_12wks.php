<?php

use yii\helpers\Html;
use kartik\date\DatePicker;
?>
<?php
$this->title = 'หญิงคลอดได้รับการฝากครรภ์ครั้งแรกก่อน 12 สัปดาห์';
$this->params['breadcrumbs'][] = ['label' => 'รายงาน-แม่และเด็ก', 'url' => ['mom/index']];
$this->params['breadcrumbs'][] = 'หญิงคลอดได้รับการฝากครรภ์ครั้งแรกก่อน 12 สัปดาห์';
?>

<div class='well'>
    <form method="POST">
    <div class="col-sm-2">
        <h5>คลอดระหว่าง : </h5>
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
<a href="#" id="btn_sql">ชุดคำสั่ง</a>
<div id="sql" style="display: none"><?= $sql ?></div>
<?php
if (isset($dataProvider))
    //$dev = \yii\helpers\Html::a('คุณศรศักดิ์ สีหะวงษ์', 'https://fb.com/sosplk', ['target' => '_blank']);


//echo yii\grid\GridView::widget([
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
            'attribute' => 'hospcode',
            'label' => 'รหัสสถานบริการ',
        ],
        [
            'attribute' => 'hospname',
            'label' => 'สถานบริการ',
            'format' => 'raw',
            'value' => function($model) use($date1,$date2) {
                return Html::a(Html::encode($model['hospname']), [
                            'mom/indiv-report-12wks',
                            'hospcode' => $model['hospcode'],
                            'date1' => $date1,
                            'date2' => $date2
                ]);
            },// end value
            'noWrap' => true
        ],
        [
            'attribute' => 'target',
            'header' => 'เป้าหมาย(คน) '
        ],
        [
            'attribute' => 'result',
            'header' => 'ผลงาน(คน)'
        ],
        [
            'class' => '\kartik\grid\FormulaColumn',
            'header' => 'ร้อยละ',
            'value' => function ($model, $key, $index, $widget) {
                $p = compact('model', 'key', 'index');
                // เขียนสูตร
                $target = $widget->col(2, $p);
                if ($target > 0) {
                    $persent = $widget->col(3, $p) / $target * 100;
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



