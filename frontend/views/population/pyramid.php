<?php
	use yii\helpers\Html;
	use miloschuman\highcharts\Highcharts;
	use kartik\grid\GridView;
    $this->title = 'ปิรามิดประชากร';
    $this->params['breadcrumbs'][] = ['label' => 'ประชากร', 'url' => ['population/index']];
	$this->params['breadcrumbs'][] = 'ปิรามิดประชากร';
?>
<div class="well">
    <form method="POST">
    <div class="row">
    	<div class="col-sm-4">
    	</div>
        <div class="col-sm-3">
            <?php
            $list = yii\helpers\ArrayHelper::map(frontend\models\ChospitalAmp::find()->all(), 'hoscode', 'hosname');
            echo yii\helpers\Html::dropDownList('hospcode',$hospcode, $list, [
                'prompt' => 'เลือกสถานบริการ',
                'class' => 'form-control'
            ]);
            ?>
        </div>
        <div class="col-sm-3">
            <button class="btn btn-danger">ตกลง</button>
        </div>
    </div>
    </form>
</div>



<?php

if(count($rawData) < 21){
    echo "<div class='alert alert-info'>ไม่มีข้อมูล</div>";
    return;
}
	$categories = [
	    		'0-4', '5-9', '10-14', '15-19',
	            '20-24', '25-29', '30-34', '35-39', '40-44',
	            '45-49', '50-54', '55-59', '60-64', '65-69',
	            '70-74', '75-79', '80-84', '85-89', '90-94',
	            '95-99', '100 + '
	        ];
	$js_categories = implode("','", $categories);

    $male = [
        		$rawData[0]['male'] * (-1), $rawData[1]['male'] * (-1), $rawData[2]['male'] * (-1)
			    , $rawData[3]['male'] * (-1), $rawData[4]['male'] * (-1), $rawData[5]['male'] * (-1)
			    , $rawData[6]['male'] * (-1), $rawData[7]['male'] * (-1), $rawData[8]['male'] * (-1)
			    , $rawData[9]['male'] * (-1), $rawData[10]['male'] * (-1), $rawData[11]['male'] * (-1)
			    , $rawData[12]['male'] * (-1), $rawData[13]['male'] * (-1), $rawData[14]['male'] * (-1)
			    , $rawData[15]['male'] * (-1), $rawData[16]['male'] * (-1), $rawData[17]['male'] * (-1)
			    , $rawData[18]['male'] * (-1), $rawData[19]['male'] * (-1), $rawData[20]['male'] * (-1)
		    ];
	$js_male = implode(',', $male);

	$female = [
				$rawData[0]['female'], $rawData[1]['female'], $rawData[2]['female']
			    , $rawData[3]['female'], $rawData[4]['female'], $rawData[5]['female']
			    , $rawData[6]['female'], $rawData[7]['female'], $rawData[8]['female']
			    , $rawData[9]['female'], $rawData[10]['female'], $rawData[11]['female']
			    , $rawData[12]['female'], $rawData[13]['female'], $rawData[14]['female']
			    , $rawData[15]['female'], $rawData[16]['female'], $rawData[17]['female']
			    , $rawData[18]['female'], $rawData[19]['female'], $rawData[20]['female']
		    ];
	$js_female = implode(',', $female);

	$max_female = max($female);
	$max_male = abs(min($male));
	$max = $max_female > $max_male ? $max_female : $max_male;

    $this->registerJs("
    	var categories = ['$js_categories'];
        $('#pyramid').highcharts({
            chart: {
                type: 'bar',
                plotBackgroundImage:'',
                height:500
            },
            credits:{'enabled':false},
            title: {
                text: 'ปิรามิดประชากร $hospname ปี ' + 2558
            },
            subtitle: {
                text: 'ข้อมูลจากแฟ้ม person'
            },
            xAxis: [{
                categories: categories,
                reversed: false,
                labels: {
                    step: 1
                }
            }, { // mirror axis on right side
                opposite: true,
                reversed: false,
                categories: categories,
                linkedTo: 0,
                labels: {
                    step: 1
                }
            }],
            yAxis: {
                title: {
                    text: null
                },
                labels: {
                    formatter: function () {
                        return (Math.abs(this.value)) + ' คน';
                    }
                },
                min: -$max,
                max: $max
            },

            plotOptions: {
                series: {
                    stacking: 'normal'
                }
            },

            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + ', อายุระหว่าง ' + this.point.category + '</b><br/>' +
                        'จำนวนประชากร: ' + Highcharts.numberFormat(Math.abs(this.point.y), 0) + ' คน';
                }
            },

            series: [{
                name: 'ชาย',
                data: [$js_male]
            }, {
                name: 'หญิง',
                data: [$js_female]
            }]
        });
    ");
?>
<div class="row">
	<div style="display: none">
	    <?=
	    Highcharts::widget([
	        'scripts' => [
	            'highcharts-more', // enables supplementary chart types (gauge, arearange, columnrange, etc.)
	            //'modules/exporting', // adds Exporting button/menu to chart
	            'themes/grid'        // applies global 'grid' theme to all charts
	        ]
	    ]);
	    ?>
	</div>
	<div id="pyramid"></div>
</div>
<br>
<div class="row"> 

	<?php 
        $gridColumn = [
            //['class' => 'yii\grid\SerialColumn'],

            [
	            'attribute' => 'age',
	            'label' => 'ช่วงอายุ (ปี)'
		    ],
		    [
		        'attribute' => 'male',
		        'label' => 'เพศชาย (คน)'
		    ],
		    [
		        'attribute' => 'female',
		        'label' => 'เพศหญิง (คน)'
		    ],
		    [
		        'class' => '\kartik\grid\FormulaColumn',
		        'label' => 'รวม (คน)',
		        'value' => function ($model, $key, $index, $widget) {
		            $p = compact('model', 'key', 'index');
		            // เขียนสูตร

		            return $widget->col(1, $p) + $widget->col(2, $p);
		        }
		    ]
		    ];
    ?>

    <?php $header = '<i class="glyphicon glyphicon-th-list"></i>  รายละเอียด '?>

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