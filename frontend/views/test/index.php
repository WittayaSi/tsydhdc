<?php
/* @var $this yii\web\View */
?>
<h1>test/index</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>
<?php

	$header = '<i class="glyphicon glyphicon-th-list"></i> test ';

	echo \kartik\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'responsive' => TRUE,
    'hover' => true,
    //'floatHeader' => true,
    'panel' => [
        'before' => '',
        'type' => \kartik\grid\GridView::TYPE_SUCCESS,
        //'after' => 'โดย ' . $dev
        'heading' => $header,
    ],
    'columns' => [
        [
            'attribute' => 'pcucodeperson',
            'label'=>'pcucodeperson'
        ],
        [
            'attribute' => 'pid',
            'label'=>'pid'
        ],
        [
            'attribute' => 'fname',
            'label'=>'fname'
        ],
        [
            'attribute' => 'lname',
            'label'=>'lname'
        ],
    ]
]);

?>
