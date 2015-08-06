<?php

namespace frontend\controllers;

class TestController extends \yii\web\Controller
{
    public function actionIndex()
    {
    	$sql = "select * from jhcisdb_07329.person p where p.nation = '99' and typelive in (1,3)";
    	try{
    		$rawdata = \Yii::$app->db2->createCommand($sql)->queryAll();
    	} catch (\yii\db\Exception $e){
    		throw new \yii\web\ConflictHttpException('sql error');
    	}

    	$dataProvider = new \yii\data\ArrayDataProvider([
    		'allModels' => $rawdata,
    		'pagination' => false
    	]);
        return $this->render('index',[
        	'dataProvider' => $dataProvider,
        ]);
    }

}
