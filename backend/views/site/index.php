<?php
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
use backend\models\SysCheckProcess;
use backend\models\SysProcessRunning;
?>
<div class="site-index">

    <div class="jumbotron">
        <div id="resp_data" style="display: none">
            <p>Data</p>
            <img src="images/Processing.gif">
        </div>
        <div id="resp_report" style="display: none">
            <p>Report</p>
            <img src="images/Processing.gif">
        </div>

        <?php 
            $checkProcess = SysProcessRunning::find()->one();
            $check = $checkProcess->running;
        ?>

    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <?php if($check === 'false'){?>
                    <p><a class="btn btn-lg btn-success" id="btn_data_process" href="#">Data Process</a></p>
                <?php }else{ ?>
                    <p><a class="btn btn-lg btn-success" href="#">Data Processing...</a></p>
                <?php }?>
            </div>
            <div class="col-lg-4">
                <?php if($check === 'false'){?>
                    <p><a class="btn btn-lg btn-success" id="btn_report_process" href="#">Report Process</a></p>
                <?php }else{ ?>
                    <p><a class="btn btn-lg btn-success" href="#">Report Processing...</a></p>
                <?php }?>
            </div>
            <div class="col-lg-4">
                <?php $route_check_process = Yii::$app->UrlManager->createUrl('process/index') ?>
                <p><a class="btn btn-lg btn-success" href="<?= $route_check_process;?>">Check Process</a></p>
            </div>
        </div>

    </div>
</div>


<?php

$route_data_process = Yii::$app->UrlManager->createUrl('process/processdata');
$route_report_process = Yii::$app->UrlManager->createUrl('process/processreport');

$script = <<< JS
$('#btn_data_process').on('click',function(e){
    $('#resp_data').toggle();
    $.ajax({
        url: '$route_data_process',
        success: function(data){
            $('#resp_data').toggle();
            alert(data+'Completed Data Process');
        }
    });
});

$('#btn_report_process').on('click', function(){
    $('#resp_report').toggle();
    $.ajax({
        url: '$route_report_process',
        success: function(data){
            $('#resp_report').toggle();
            alert(data+'Completed Report Process')
        }
    });
})
JS;

$this->registerJs($script);



?>
