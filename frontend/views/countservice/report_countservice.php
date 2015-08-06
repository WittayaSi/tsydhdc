<?php

use yii\helpers\Html;
?>
<?php
$this->params['breadcrumbs'][] = ['label' => 'บริการผู้ป่วยนอก', 'url' => ['countservice/index']];
$this->params['breadcrumbs'][] = 'การมารับบริการผู้ป่วยนอก';
?>

<div class='well'>
    <form method="POST">
        <div class='row'>
            <div class="col-sm-3">
                
            </div>
            <div class="col-sm-1">
            <h5>ปีงบประมาณ: </h5>
            </div>
            <div class='col-sm-3'>
               
                <?php
                 $list_year =  [
                    '2014' => '2557',
                    '2015' => '2558',
                    '2016' => '2559'];
                echo Html::dropDownList('selyear', $selyear, $list_year,[
                    'class' => 'form-control'
                ]);
                ?>
            </div>
            <div class='col-sm-3'>

                <button class='btn btn-danger'>ประมวลผล</button>
            </div>
        </div>
    </form>
</div>
<!--<a href="#" id="btn_sql">ชุดคำสั่ง</a> -->
<div id="sql" style="display: none"><?= '' ?></div>

    <?php
    if (isset($dataProvider)) {
        //$dev = Html::a('คุณอุเทน จาดยางโทน', 'https://fb.com/tehnn', ['target' => '_blank']);


        $y = $selyear + 543;
        $y = substr($y, 2, 2);
        $py = $y - 1;

        $header = '<i class="glyphicon glyphicon-th-list"></i> การรับบริการผู้ป่วยนอก ';
        echo \kartik\grid\GridView::widget([
//echo \kartik\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'responsive' => TRUE,
            'hover' => true,
            'floatHeader' => true,
            'panel' => [
              'before' => '',
              'type' => \kartik\grid\GridView::TYPE_SUCCESS,
              'heading' => $header,
              //'after' => 'โดย ' . $dev
            ],
            'containerOptions' => ['style'=>'overflow: auto;'],
            'columns' => [
                [
                    'attribute' => 'hoscode',
                    'label' => 'รหัส'
                ],
                [
                    'attribute' => 'hosname',
                    'label' => 'สถานบริการ',
                    'noWrap' => true
                ],
                [
                    'attribute' => 'oct1',
                    'label' => "ตค" . $py . "(ครั้ง)"
                ],
                [
                    'attribute' => 'nov1',
                    'label' => "พย" . $py . "(ครั้ง)"
                ],
                [
                    'attribute' => 'dec1',
                    'label' => "ธค" . $py . "(ครั้ง)"
                ],
                [
                    'attribute' => 'jan1',
                    'label' => "มค" . $y . "(ครั้ง)"
                ],
                [
                    'attribute' => 'feb1',
                    'label' => "กพ" . $y . "(ครั้ง)"
                ],
                [
                    'attribute' => 'mar1',
                    'label' => "มีค" . $y . "(ครั้ง)"
                ],
                [
                    'attribute' => 'apr1',
                    'label' => "เมย" . $y . "(ครั้ง)"
                ],
                [
                    'attribute' => 'may1',
                    'label' => "พค" . $y . "(ครั้ง)"
                ],
                [
                    'attribute' => 'jun1',
                    'label' => "มิย" . $y . "(ครั้ง)"
                ],
                [
                    'attribute' => 'jul1',
                    'label' => "กค" . $y . "(ครั้ง)"
                ],
                [
                    'attribute' => 'aug1',
                    'label' => "สค" . $y . "(ครั้ง)"
                ],
                [
                    'attribute' => 'sep1',
                    'label' => "กย" . $y . "(ครั้ง)"
                ],
            ]
        ]);
    }
?>



