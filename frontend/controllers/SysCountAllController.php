<?php

namespace frontend\controllers;

use Yii;
use frontend\models\SysCountAll;
use frontend\models\SysCountAllSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SysCountAllController implements the CRUD actions for SysCountAll model.
 */
class SysCountAllController extends Controller
{

    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $year = '';
        $sqlbetween = "between '201410' and '201509'";
        if(!empty($_POST['fyscalyear'])){
            $year = $_POST['fyscalyear'];
            if($year === '2558'){
                $sqlbetween = "between '201410' and '201509'";
            }else { 
                if($year === '2557'){
                    $sqlbetween = "between '201310' and '201409'";
                }else {
                    $sqlbetween = "between '201210' and '201309'";
                }
            }
        }
        $sql = $this->sql($sqlbetween);
        $data = \Yii::$app->db->createCommand($sql)->queryAll();
        //$searchModel = new SysCountAllSearch();
        $dataProvider = new \yii\data\ArrayDataProvider([
            'key' => 'hospcode',
            'allModels' => $data,
            'pagination' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'year' => $year,
        ]);
    }

    public function actionView($id)
    {
        //$imp = implode(',', $id);
        $year = '2558';
        $sql = "SELECT * FROM sys_count_all WHERE hospcode = ".$id." AND selyear = ".$year;
        $data = \Yii::$app->db->createCommand($sql)->queryAll();
        $dataProvider = new \yii\data\ArrayDataProvider([
            'key' => 'hospcode',
            'allModels' => $data,
            'pagination' => false,
        ]);
        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'model' => $this->findModel($id),
        ]);
    }

    private function findModel($id)
    {
        if (($model = SysCountAll::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionIndex2() {
        $searchModel = new SysCountAllSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$searchModel->month = date('Ym');
        //$dataProvider->month = date('Ym');
        //$searchModel->hospcode=$hospcode;

        return $this->render('index2', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    private function sql($sqlbetween){
        $sql = "SELECT  t.hospcode, REPLACE (t.hospname,'สถานบริการสาธารณสุขชุมชน','สสช.') as hospname,
                sum(t.person) as person,
                sum(t.death) as death,
                sum(t.service) as service,
                sum(t.ncdscreen) as ncdscreen,
                sum(t.accident) as accident,
                sum(t.procedure_opd) as procedure_opd,
                sum(t.anc) as anc,
                sum(t.chronicfu) as chronicfu,
                sum(t.labfu) as labfu,
                sum(t.diagnosis_opd) as diagnosis_opd,
                sum(t.chronic) as chronic,
                sum(t.fp) as fp,
                sum(t.epi) as epi,
                sum(t.nutrition) as nutrition,
                sum(t.prenatal) as prenatal,
                sum(t.labor) as labor,
                sum(t.postnatal) as postnatal,
                sum(t.newborn) as newborn,
                sum(t.newborncare) as newborncare,
                sum(t.dental) as dental,
                sum(t.admission) as admission,
                sum(t.diagnosis_ipd) as diagnosis_ipd,
                sum(t.procedure_ipd) as procedure_ipd

                from sys_count_all t where t.hospcode in (select hoscode from chospital_amp) and t.month $sqlbetween
                GROUP BY t.hospcode";
        return $sql;
    }

}
