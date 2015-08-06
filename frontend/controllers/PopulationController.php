<?php

namespace frontend\controllers;

class PopulationController extends \yii\web\Controller
{
	public $enableCsrfValidation = false;

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionPyramid()
    {
    	$hospname = '';
    	$sql = "select substr(t.age_range,3, 10) as age, sum(t.male) as male, sum(t.female) as female 
    			from sys_ages_level_3 t 
    			group by t.age_range";

    	if (!empty($_POST['hospcode'])) {
            $h = $_POST['hospcode'];
            $m= \frontend\models\ChospitalAmp::findOne(['hoscode'=>$h]);
            $hospname = $m->hosname;
            $sql = "select substr(t.age_range, 3, 10) as age, t.male as male, t.female as female
            		from sys_ages_level_3 t
            		where t.hospcode = $h
            		group by t.age_range";
        }

        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',
            'allModels' => $rawData,
            'pagination' => FALSE,
        ]);

        return $this->render('pyramid',[
        		'dataProvider' => $dataProvider,
        		'rawData' => $rawData,
        		'hospname' => $hospname,
        		'hospcode'=>isset($_POST['hospcode'])?$_POST['hospcode']:'',
        	]);
    }

    public function actionCheckcid()
    {
        //$hospname = '';
        $sql = "SELECT * FROM cid_error";
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',
            'allModels' => $rawData,
            'pagination' => FALSE,
        ]);

        return $this->render('checkcid',[
                'dataProvider' => $dataProvider,
                'rawData' => $rawData,
                //'hospname' => $hospname,
                //'hospcode'=>isset($_POST['hospcode'])?$_POST['hospcode']:'',
            ]);
    }

    public function actionCheckcidDetails($hospcode = null)
    {
        $sql = "SELECT * FROM cid_error_data where hospcode = '$hospcode'";
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',
            'allModels' => $rawData,
            'pagination' => FALSE,
        ]);

        return $this->render('checkcidDetails',[
                'dataProvider' => $dataProvider,
                'rawData' => $rawData,
                'hospcode' => $hospcode
                //'hospname' => $hospname,
                //'hospcode'=>isset($_POST['hospcode'])?$_POST['hospcode']:'',
            ]);
    }

    public function actionTypeArea(){
        $sql = "SELECT * FROM population_typearea";
        try{
            $rawData = \yii::$app->db->createCommand($sql)->queryAll();
        } catch(\yii\db\Exception $e){
            throw new E\yii\web\ConflictHttpException('sql error');
        }

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => false,
        ]);

        return $this->render('typearea',[
            'dataProvider' => $dataProvider,
            'rawData' => $rawData,
        ]);
    }

}
