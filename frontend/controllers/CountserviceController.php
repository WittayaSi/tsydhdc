<?php

namespace frontend\controllers;



class CountserviceController extends \yii\web\Controller
{
    public $enableCsrfValidation = false; 

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionReportCountService()
    {
    	$selyear = date('Y');
        
        if (!empty($_POST['selyear'])) {
            $selyear = $_POST['selyear'];
            
        }
        $sql = "select * from sys_count_service where selyear=$selyear";

        try {
            $rawData = \Yii::$app->db2->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',
            'allModels' => $rawData,
            'pagination' => FALSE,
        ]);
        $sql ="";
        return $this->render('report_countservice', [
                    'dataProvider' => $dataProvider,
                    'sql'=>$sql,
                    'selyear' => $selyear
        ]);
    }

}
