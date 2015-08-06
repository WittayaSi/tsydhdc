<?php
use yii\helpers\Html;
$this->title = 'รายงาน-การรับบริการ';
	$this->params['breadcrumbs'][] = 'รายงาน-การรับบริการ';
?>
<h3>รายงาน-การรับบริการ</h3></br>
<div class="well">
<p>
    <?php
    echo Html::a('1) จำนวนผู้มารับบริการผู้ป่วยนอก', ['countservice/report-count-service']);
    ?>
</p>
</div>

<div class="footerrow" style="padding-top: 30px">
    <div class="alert alert-success">
        หมายเหตุ : ระบบรายงานอยู่ระหว่างพัฒนาอย่างต่อเนื่อง
    </div>
</div>
