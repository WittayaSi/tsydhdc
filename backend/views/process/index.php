<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\Pjax;
?>
<center>
	<div class="alert alert-success"><h3>ตรวจสอบการทำงาน</h3></div>
</center>
<?php Pjax::begin(); ?>
<?= Html::a("Refresh", ['process/index'], ['class' => 'btn btn-lg btn-primary', 'id' => 'refreshButton','style'=>'display:none']) ?>
<center>
<div style="border-bottom: gray solid 1px;padding-bottom: 10px">
    Server Time: <span style="background-color: white;margin: 15px" id="divtoBlink"><b><?= $server_time ?></b></span>
    Current Process: <span style="background-color: white;margin: 15px"><b><?=$process_name?></b></span>
    Start Time: <span style="background-color: white;margin: 15px"><b><?=$process_time?></b></span>
</div>
</center>
<br>


<?php
echo kartik\grid\GridView::widget([
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
        //'before' => '',
    //'after'=>''
    ]
]);
?>
<?php Pjax::end(); ?>

<?php
$script = <<< JS
$(document).ready(function() {
    setInterval(function(){ $("#refreshButton").click(); }, 5000);
});

setInterval(function () {
    $("#divtoBlink").css("background-color", function () {
        this.switch = !this.switch
        return this.switch ? "green" : "white"
    });
}, 1000)

JS;
$this->registerJs($script);
?>

