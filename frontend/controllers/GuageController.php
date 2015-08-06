<?php
namespace frontend\controllers;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use frontend\Models\ChospitalAmp;

class GuageController extends Controller{

	public function actionDetails($value){
        $sql = "SELECT DISTINCT *
                FROM person p
                WHERE p.birth BETWEEN '20090401' AND '20100331' AND p.discharge = '9'
                    AND p.typearea IN (1,3) AND p.NATION = '099' AND p.hospcode = $value";
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

        $sql1 = "SELECT *, TIMESTAMPDIFF(YEAR,p.birth,a.date_serv) AS AGES
                FROM person p
                    LEFT JOIN epi a ON a.pid=p.pid AND a.hospcode=p.hospcode AND a.vaccinetype='035'
                WHERE p.birth BETWEEN '20090401' AND '20100331' AND p.discharge = '9'
                    AND p.typearea IN (1,3) AND p.NATION = '099' AND TIMESTAMPDIFF(YEAR,p.birth,a.date_serv) <> '' 
                    AND TIMESTAMPDIFF(YEAR,p.birth,a.date_serv) <= 5
                    AND p.hospcode = $value";
        try {
            $rawData1 = \Yii::$app->db->createCommand($sql1)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $dataProvider1 = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',
            'allModels' => $rawData1,
            'pagination' => FALSE,
        ]);

        return $this->render('details', [
                    'dataProvider' => $dataProvider,
                    'dataProvider1' => $dataProvider1,
        ]);
    }
}
?>