<?php
	use yii\helpers\Html;
	use miloschuman\highcharts\Highcharts;
	use kartik\grid\GridView;
    $this->title = 'รายงาน-แม่และเด็ก';
	$this->params['breadcrumbs'][] = 'รายงาน-แม่และเด็ก';
?>
<h3> รายงาน-แม่และเด็ก </h3></br>
<div class="well">
    
 <p>
    <?php
    echo \yii\helpers\Html::a('1) หญิงคลอดได้รับการฝากครรภ์ครบ 5 ครั้งตามเกณฑ์', ['mom/report5times']);
    ?>
</p>
<p>
    <?php
    echo \yii\helpers\Html::a('2) หญิงคลอดได้รับการฝากครรภ์ครั้งแรก ก่อน 12 สัปดาห์', ['mom/report12wks']);
    ?>
</p>

<p>
    <?php
    echo \yii\helpers\Html::a('3) ทารกแรกเกิดน้ำหนักน้อยกว่า 2500 กรัม', ['mom/reportlessthan2500g']);
    ?>
</p>

<p>
    <?php
    //echo \yii\helpers\Html::a('4) ภาวะโภชนาการเด็ก 0-5 ปี เป็นปกติ', ['mom/report5']);
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