<?php

namespace frontend\controllers;

use yii;

class PopulationController extends \yii\web\Controller {

    public $enableCsrfValidation = false;

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionPyramid() {
        $hospname = '';
        $sql = "select substr(t.age_range,3, 10) as age, sum(t.male) as male, sum(t.female) as female 
    			from sys_pyramid_level_3 t 
    			group by t.age_range";

        if (!empty($_POST['hospcode'])) {
            $h = $_POST['hospcode'];
            $m = \frontend\models\ChospitalAmp::findOne(['hoscode' => $h]);
            $hospname = $m->hosname;
            $sql = "select substr(t.age_range, 3, 10) as age, t.male as male, t.female as female
            		from sys_pyramid_level_3 t
            		where t.hospcode = $h
            		group by t.age_range";
        }

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

        return $this->render('pyramid', [
                    'dataProvider' => $dataProvider,
                    'rawData' => $rawData,
                    'hospname' => $hospname,
                    'hospcode' => isset($_POST['hospcode']) ? $_POST['hospcode'] : '',
        ]);
    }

    public function actionCheckcid() {
        //$hospname = '';
        $sql = "SELECT * FROM sys_cid_error";
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

        return $this->render('checkcid', [
                    'dataProvider' => $dataProvider,
                    'rawData' => $rawData,
                        //'hospname' => $hospname,
                        //'hospcode'=>isset($_POST['hospcode'])?$_POST['hospcode']:'',
        ]);
    }

    public function actionCheckcidDetails($hospcode = null) {
        $sql = "SELECT * FROM sys_cid_error_data where hospcode = '$hospcode'";
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

        return $this->render('checkcidDetails', [
                    'dataProvider' => $dataProvider,
                    'rawData' => $rawData,
                    'hospcode' => $hospcode
                        //'hospname' => $hospname,
                        //'hospcode'=>isset($_POST['hospcode'])?$_POST['hospcode']:'',
        ]);
    }

    public function actionTypeArea() {
        $sql = "SELECT * FROM sys_person_type";
        try {
            $rawData = \yii::$app->db2->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new E\yii\web\ConflictHttpException('sql error');
        }

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => false,
        ]);

        return $this->render('typearea', [
                    'dataProvider' => $dataProvider,
                    'rawData' => $rawData,
        ]);
    }

    public function actionDuplicate() {
        $sql = "SELECT p.CID as cid,GROUP_CONCAT(CONCAT(p.NAME,' ',p.LNAME)) as fullname, GROUP_CONCAT(p.TYPEAREA) as typearea,GROUP_CONCAT(p.pid) as his,
GROUP_CONCAT(p.birth) as birth,
GROUP_CONCAT(p.HOSPCODE) as hospcode
FROM f43_person p
WHERE LENGTH(p.CID) = 13 and p.typearea in ('1','3')
AND p.NATION = '099' and p.discharge='9' and p.cid not like '0%' 
GROUP BY p.CID
HAVING COUNT(p.CID)>1
order by p.hospcode;";
        try {
            $rawData = \yii::$app->db2->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new E\yii\web\ConflictHttpException('sql error');
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => false
        ]);

        return $this->render('duplicate', [
                    'dataProvider' => $dataProvider,
                    'rawData' => $rawData
        ]);
    }

    public function actionEvoltarget() {
        $date1 = "2016-10-01";
        $date2 = date('Y-m-d');
        if (Yii::$app->request->isPost) {
            $date1 = $_POST['date1'];
            $date2 = $_POST['date2'];
        }

        $sql = "select * from f43_person p "
                . "where (p.birth between '$date1' and '$date2')"
                . "and p.nation = '099'"
                . "and p.typearea in ('1','3')"
                . "and p.discharge = '9' ";
        try {
            $rawData = \yii::$app->db2->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }

        return $this->render('evolTarget', [
                    'rawData' => $rawData,
                    'date1' => $date1,
                    'date2' => $date2
        ]);
    }

}
