<?php
	use yii\helpers\Html;
	use miloschuman\highcharts\Highcharts;
	use kartik\grid\GridView;
    $this->title = 'รายงาน-คัดกรอง';
	$this->params['breadcrumbs'][] = 'รายงาน-คัดกรอง';
?>
<h3> รายงาน-คัดกรอง </h3></br>
<div class="well">
    
 <p>
    <?php
    echo \yii\helpers\Html::a('1) ประชาชนอายุ 35 ปีขึ้นไปได้รับการคัดกรองเบาหวาน', ['screen/report-screen-dm']);
    ?>
</p>
<p>
    <?php
    echo \yii\helpers\Html::a('2) ประชาชนอายุ 35 ปีขึ้นไปได้รับการคัดกรองความดันโลหิต', ['screen/report-screen-ht']);
    ?>
</p>

<p>
    <?php
    echo \yii\helpers\Html::a('3) ผู้ป่วยรายใหม่ จาก กลุ่ม PreDM', ['screen/report-newpt-from-predm']);
    ?>
</p>

<p>
    <?php
    echo \yii\helpers\Html::a('3) ผู้ป่วยรายใหม่ จาก กลุ่ม PreHT', ['screen/report-newpt-from-preht']);
    ?>
</p>

<p>
    <?php
    //echo \yii\helpers\Html::a('5) การดูแลหญิงหลังคลอดครบ 3 ครั้งตามเกณฑ์', ['mom/report6']);
    ?>
</p>

<div class="footerrow" style="padding-top: 30px">
    <div class="alert alert-success">
        หมายเหตุ : ระบบรายงานอยู่ระหว่างพัฒนาอย่างต่อเนื่อง
    </div>
</div>

</div>
