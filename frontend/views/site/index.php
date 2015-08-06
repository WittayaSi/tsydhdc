<?php
use yii\helpers\Html;
use miloschuman\highcharts\Highcharts;
use \yii\helpers\ArrayHelper;
use frontend\models\ChospitalAmp;
use kartik\widgets\Select2;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
$this->title = 'My Yii Application';
?>



<div style='display: none'>
    <?=
    Highcharts::widget([
        'scripts' => [
            'highcharts-more',
            'themes/grid'
        //'modules/exporting',
        ]
    ]);
    ?>
</div>

<?php
    $this->registerJsFile('./js/chart_dial.js');
    $hospcode = '';
    $hospcode = $hosname;
?>
<div class="site-index">

        

        <p class="lead">
            <div class="alert alert-success">
            <div class="row">
                <div class="col-lg-4" style="text-align: center;">
                </div>
                <div class="col-lg-4" style="text-align: center;">
                    <p>เลือกสถานบริการสาธารณสุข</p>
                    <form method="POST">
                        <p>
                        <?=
                            Select2::widget([
                                'name' => 'hospcode',
                                'data' => ArrayHelper::map(ChospitalAmp::find()->all(),'hoscode','hosname'),
                                'options' => [
                                    'placeholder' => empty($hosname)? 'Select here...' : $hosname,
                                ],
                            ]);
                        ?>
                        </p>
                        <p>
                        <div>
                            <button class = 'btn btn-success'>Search</button>
                        </div>
                        </p>
                    </form>
                    
                    <div id="resp" style="display: none">
                        <img src="backend\web\images\Processing.gif">
                    </div>
                </div>
                <div class="col-lg-4" style="text-align: center;">
                </div>
            </div>
            </div>
                <div class="alert alert-danger" style="text-align: center;">
                    <?php if(!empty($hospcode)){echo '<h3>'.$hosname.'</h3>';}else{echo '<h3>ภาพรวมอำเภอ</h3>';} ?>
                </div>
        </p>

    <?php Pjax::begin(); ?>
    <div class="body-content">

        <div class="row">
            <div class="col-lg-4" style="text-align: center;">
                <?php
                    if(empty($hospcode)){
                        $command = Yii::$app->db->createCommand("SELECT target FROM indicator_all WHERE id = 1 ");
                        $target = $command->queryScalar();

                        $command = Yii::$app->db->createCommand("SELECT result FROM indicator_all WHERE id = 1 ");
                        $result = $command->queryScalar();
                    }else{
            
                        $command = Yii::$app->db->createCommand("SELECT target FROM sys_chart_dial_dtp5 WHERE hospcode = $data ");
                        $target = $command->queryScalar();
                        
                        $command = Yii::$app->db->createCommand("SELECT result FROM sys_chart_dial_dtp5 WHERE hospcode = $data ");
                        $result = $command->queryScalar(); 
                    }
                    
                    $a=0.00;
                    if($target>0){
                        $a = $result/$target*100;
                        $a = number_format($a,2);
                    }
                     $base = 85;
                    $title = 'dsdfd';
                    $this->registerJs("
                                var obj_div=$('#ch1');
                                var title = ' <br>เด็กอายุ 5 ปีได้รับวัคซีน DTP5';
                                gen_dial(obj_div,$base,$a,title);
                            ");

                ?>
                <?php $data = base64_encode(base64_encode($data)); ?>
                <a href="index.php?r=site/details&id=<?php echo $data; ?>"><div id="ch1"></div></a>
            </div>
                <div class="col-lg-4" style="text-align: center;">
                <?php

                    $data = base64_decode(base64_decode($data));
                    if(empty($hospcode)){
                        $command = Yii::$app->db->createCommand("SELECT target FROM indicator_all WHERE id = 2 ");
                        $target = $command->queryScalar();

                        $command = Yii::$app->db->createCommand("SELECT result FROM indicator_all WHERE id = 2 ");
                        $result = $command->queryScalar();
                    }else{
                        $command = Yii::$app->db->createCommand("SELECT target FROM sys_chart_dial_anc12wks WHERE hospcode = $data");
                        $target = $command->queryScalar();
                        
                        $command = Yii::$app->db->createCommand("SELECT result FROM sys_chart_dial_anc12wks WHERE hospcode = $data");
                        $result = $command->queryScalar(); 
                    } 

                    $a=0.00;
                    if($target>0){
                        $a = $result/$target*100;
                        $a = number_format($a,2);
                    }
                     $base = 85;
                    $title = 'dsdfd';
                    $this->registerJs("
                                var obj_div=$('#ch2');
                                var title = 'หญิงคลอดได้รับการฝากครรภ์ครั้งแรก<br>ก่อน 12 สัปดาห์';
                                gen_dial(obj_div,$base,$a,title);
                            ");

                ?>
                <?php $data = base64_encode(base64_encode($data)); ?>
                <a href="index.php?r=site/details_anc12wks&id=<?php echo $data; ?>"><div id="ch2"></div></a>
            </div>
            <div class="col-lg-4">
                <?php
                    $data = base64_decode(base64_decode($data));
                    if(empty($hospcode)){
                        $command = Yii::$app->db->createCommand("SELECT target FROM indicator_all WHERE id = 3 ");
                        $target = $command->queryScalar();

                        $command = Yii::$app->db->createCommand("SELECT result FROM indicator_all WHERE id = 3 ");
                        $result = $command->queryScalar();
                    }else{
                        $command = Yii::$app->db->createCommand("SELECT target FROM sys_chart_dial_anc5times WHERE hospcode = $data");
                        $target = $command->queryScalar();
                        
                        $command = Yii::$app->db->createCommand("SELECT result FROM sys_chart_dial_anc5times WHERE hospcode = $data");
                        $result = $command->queryScalar(); 
                    } 
                
                $a=0.00;
                if($target>0){
                    $a = $result/$target*100;
                    $a = number_format($a,2);
                }
                 $base = 90;
                
                $this->registerJs("
                            var obj_div=$('#ch3');
                            var title = 'หญิงคลอดได้รับการฝากครรภ์ครบ <br>5 ครั้งตามเกณฑ์ ';
                            gen_dial(obj_div,$base,$a,title);
                        ");
                ?>
                <?php $data = base64_encode(base64_encode($data)); ?>
                    <a href="index.php?r=site/details_anc5times&id=<?php echo $data; ?>"><div id="ch3"></div></a>
            </div>
        </div>

        <br>
        <div class="row">
            <div class="col-lg-4" style="text-align: center;">
                <?php $data = base64_decode(base64_decode($data)); ?>
                <?php
                    if(empty($hospcode)){
                        $command = Yii::$app->db->createCommand("SELECT target FROM indicator_all WHERE id = 4 ");
                        $target = $command->queryScalar();

                        $command = Yii::$app->db->createCommand("SELECT result FROM indicator_all WHERE id = 4 ");
                        $result = $command->queryScalar();
                    }else{
                        $command = Yii::$app->db->createCommand("SELECT HTtarget FROM sys_chart_dial_screen_ht WHERE hospcode = $data ");
                        $target = $command->queryScalar();
                        
                        $command = Yii::$app->db->createCommand("SELECT HTresult FROM sys_chart_dial_screen_ht WHERE hospcode = $data ");
                        $result = $command->queryScalar();
                    }
                    
                    $a=0.00;
                    if($target>0){
                        $a = $result/$target*100;
                        $a = number_format($a,2);
                    }
                     $base = 90;
                     $title = 'dsdfd';
                    $this->registerJs("
                                var obj_div=$('#ch4');
                                var title = 'ประชาชนอายุ 35 ปีขึ้นไปได้รับการ<br>คัดกรองความดันโลหิต';
                                gen_dial(obj_div,$base,$a,title);
                            ");
                ?>
                    <?php $data = base64_encode(base64_encode($data)); ?>
                    <a href="index.php?r=site/details_screen_ht&id=<?php echo $data; ?>"><div id="ch4"></div></a>
            </div>

            <div class="col-lg-4" style="text-align: center;">
                <?php $data = base64_decode(base64_decode($data)); ?>
                <?php
                    if(empty($hospcode)){
                        $command = Yii::$app->db->createCommand("SELECT target FROM indicator_all WHERE id = 5 ");
                        $target = $command->queryScalar();

                        $command = Yii::$app->db->createCommand("SELECT result FROM indicator_all WHERE id = 5 ");
                        $result = $command->queryScalar();
                    }else{
                        $command = Yii::$app->db->createCommand("SELECT DMtarget FROM sys_chart_dial_screen_dm WHERE hospcode = $data ");
                        $target = $command->queryScalar();
                        
                        $command = Yii::$app->db->createCommand("SELECT DMresult FROM sys_chart_dial_screen_dm WHERE hospcode = $data ");
                        $result = $command->queryScalar();
                    }
                    
                    $a=0.00;
                    if($target>0){
                        $a = $result/$target*100;
                        $a = number_format($a,2);
                    }
                     $base = 90;
                     $title = 'dsdfd';
                    $this->registerJs("
                                var obj_div=$('#ch5');
                                var title = 'ประชาชนอายุ 35 ปีขึ้นไปได้รับการ<br>คัดกรองเบาหวาน';
                                gen_dial(obj_div,$base,$a,title);
                            ");
                ?>
                    <?php $data = base64_encode(base64_encode($data)); ?>
                    <a href="index.php?r=site/details_screen_dm&id=<?php echo $data; ?>"><div id="ch5"></div></a>
            </div>

            
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>
<?php
    $linkDetail = <<< JS
    $('#ch6').on('click', function(e){
        $('#resp').toggle();
    });
JS;
$this->registerJs($linkDetail);
?>