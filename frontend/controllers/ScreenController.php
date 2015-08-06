<?php

namespace frontend\controllers;
use yii;

class ScreenController extends \yii\web\Controller
{

	public $enableCsrfValidation = false;

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionReportScreenDm()
    {
    	$timestamp = strtotime('-1 years');
    	$date1 = date('Y-m-d',$timestamp);
    	$date2 = date('Y-m-d');
    	//$bdg_date = '2014-03-31';

    	if(Yii::$app->request->isPost){
    		$date1 = $_POST['date1'];
    		$date2 = $_POST['date2'];
    	}

    	$sql = "
    		select  h.hoscode as hospcode, h.hosname as hospname,
			(SELECT hos_target from
			 (select p.hospcode , count(*) as hos_target from person p  
			           where p.discharge = '9' and p.typearea in (1,3) and p.nation ='099' 
			           and (TIMESTAMPDIFF(YEAR,p.birth,'$date1') >= 35 )
			           and concat(p.hospcode ,p.pid) not in  
			           ( select concat(hospcode,pid) from chronic c where c.chronic between 'E10' and 'E1499' )
			group by p.hospcode ) as t
			where  t.hospcode = h.hoscode
			) as target ,
			(SELECT hos_doit from
			          (select p.hospcode,count(*) as hos_doit from ncdscreen n  
			           inner join person p on n.hospcode = p.hospcode and n.pid = p.pid 
			           where p.discharge = '9' and p.typearea in ('1', '3') and p.nation ='099' 
			           and (TIMESTAMPDIFF(YEAR,p.birth,'$date1') >= 35 ) and n.date_serv between '$date1' and '$date2'
								AND n.height IS NOT NULL AND n.height > 0
								AND n.weight IS NOT NULL AND n.weight > 0
								AND n.sbp_1 IS NOT NULL AND n.sbp_1 > 0
								AND n.dbp_1 IS NOT NULL AND n.dbp_1 > 0
								AND n.bslevel IS NOT NULL AND n.bslevel > 0
			           and concat(p.hospcode,p.pid) not in  
			           ( select concat(c.hospcode,c.pid) from chronic c where c.chronic between 'E10' and 'E1499' ) group by p.hospcode) as r
			where r.hospcode = h.hoscode
			) as result
			from chospital_amp h
			GROUP BY hospcode;";

		try{
			$rawdata = \Yii::$app->db->createCommand($sql)->queryAll();
		} catch(\yii\db\Exception $e){
			throw new \yii\web\ConflictHttpException('sql error');
		}

		$dataProvider = new \yii\data\ArrayDataProvider([
			'allModels' => $rawdata,
			'pagination' => false,
		]);

		return $this->render('report_screen_dm',[
			'dataProvider' => $dataProvider,
			'date1' => $date1,
			'date2' => $date2,
			'sql' => $sql
		]);
    }

    public function actionReportScreenHt()
    {
    	$timestamp = strtotime('-1 years');
    	$date1 = date('Y-m-d',$timestamp);
    	$date2 = date('Y-m-d');
    	//$bdg_date = '2014-03-31';

    	if(Yii::$app->request->isPost){
    		$date1 = $_POST['date1'];
    		$date2 = $_POST['date2'];
    	}

    	$sql = "
    		select  h.hoscode as hospcode, h.hosname as hospname,
			(SELECT hos_target from
			 (select p.hospcode , count(*) as hos_target from person p  
			           where p.discharge = '9' and p.typearea in (1,3) and p.nation ='099' 
			           and (TIMESTAMPDIFF(YEAR,p.birth,'$date1') >= 35 )
			           and concat(p.hospcode ,p.pid) not in  
			           ( select concat(hospcode,pid) from chronic c where c.chronic between 'I10' and 'I1599' )
			group by p.hospcode ) as t
			where  t.hospcode = h.hoscode
			) as target ,
			(SELECT hos_doit from
			          (select p.hospcode,count(*) as hos_doit from ncdscreen n  
			           inner join person p on n.hospcode = p.hospcode and n.pid = p.pid 
			           where p.discharge = '9' and p.typearea in ('1', '3') and p.nation ='099' 
			           and (TIMESTAMPDIFF(YEAR,p.birth,'$date1') >= 35 ) and n.date_serv between '$date1' and '$date2'
								AND n.height IS NOT NULL AND n.height > 0
								AND n.weight IS NOT NULL AND n.weight > 0
								AND n.sbp_1 IS NOT NULL AND n.sbp_1 > 0
								AND n.dbp_1 IS NOT NULL AND n.dbp_1 > 0
								AND n.bslevel IS NOT NULL AND n.bslevel > 0
			           and concat(p.hospcode,p.pid) not in  
			           ( select concat(c.hospcode,c.pid) from chronic c where c.chronic between 'I10' and 'I1599' ) group by p.hospcode) as r
			where r.hospcode = h.hoscode
			) as result
			from chospital_amp h
			GROUP BY hospcode;";
		try{
			$rawdata = \Yii::$app->db->createCommand($sql)->queryAll();
		} catch(\yii\db\Exception $e){
			throw new \yii\web\ConflictHttpException('sql error');
		}

		$dataProvider = new \yii\data\ArrayDataProvider([
			'allModels' => $rawdata,
			'pagination' => false,
		]);

		return $this->render('report_screen_ht',[
			'dataProvider' => $dataProvider,
			'date1' => $date1,
			'date2' => $date2,
			'sql' => $sql
		]);
    }

    public function actionReportNewptFromPredm()
    {
    	$timestamp = strtotime('-1 years');
    	$date1 = date('Y-m-d',$timestamp);
    	$date2 = date('Y-m-d');
    	//$bdg_date = '2014-03-31';

    	if(Yii::$app->request->isPost){
    		$date1 = $_POST['date1'];
    		$date2 = $_POST['date2'];
    	}

    	$sql = "
    		SELECT h.hoscode hospcode
				,h.hosname hospname
				,a.target
				,a.result
			FROM chospital_amp h
			LEFT JOIN (
				SELECT p.hospcode
							,COUNT(DISTINCT IF(p.DM_target='NODM',p.pid,NULL)) target
							,COUNT(DISTINCT IF(p.DM_work='NODM',p.pid,NULL)) result
				FROM(
					SELECT p.hospcode
								,p.pid
								,IF(c.pid IS NOT NULL, 'NODM', NULL) DM_work #edit from (c.pid is null)  to (c.pid is not null)
								,IF(cc.pid IS NULL, 'NODM', NULL) DM_target
								/*,c.DATE_DIAG
								,p.cid
								,p.hn
								,concat(p.name,' ',p.lname) ptname
								,timestampdiff(year,p.birth,@ds1) age
								,p.typearea
								,p.nation
								,p.discharge 
								,n.date_serv
								,n.bslevel*/
					FROM person p
					LEFT JOIN ncdscreen n ON n.pid=p.pid AND n.hospcode=p.hospcode
					LEFT JOIN chronic c ON c.pid=p.pid AND c.hospcode=p.hospcode 
											AND c.chronic BETWEEN 'E10' AND 'E1499' 
											AND c.DATE_DIAG BETWEEN '$date1' AND '$date2'

					LEFT JOIN chronic cc ON cc.pid=p.pid AND cc.hospcode=p.hospcode AND cc.chronic BETWEEN 'E10' AND 'E1499' 
																AND c.DATE_DIAG < n.date_serv

					WHERE TIMESTAMPDIFF(YEAR,p.birth,'$date1')>=35
						AND p.typearea IN (1,3)
						AND p.nation='099'
						AND p.discharge='9'
						AND n.date_serv BETWEEN '$date1' AND '$date2'
						AND n.bslevel BETWEEN 100 AND 125
				) p
				GROUP BY p.hospcode
			) a ON a.hospcode=h.hoscode;";

		try{
			$rawdata = \Yii::$app->db->createCommand($sql)->queryAll();
		} catch(\yii\db\Exception $e){
			throw new \yii\web\ConflictHttpException('sql error');
		}

		$dataProvider = new \yii\data\ArrayDataProvider([
			'allModels' => $rawdata,
			'pagination' => false,
		]);

		return $this->render('report_newpt_from_predm',[
			'dataProvider' => $dataProvider,
			'date1' => $date1,
			'date2' => $date2,
			'sql' => $sql
		]);
    }

    public function actionReportNewptFromPreht()
    {
    	$timestamp = strtotime('-1 years');
    	$date1 = date('Y-m-d',$timestamp);
    	$date2 = date('Y-m-d');
    	//$bdg_date = '2014-03-31';

    	if(Yii::$app->request->isPost){
    		$date1 = $_POST['date1'];
    		$date2 = $_POST['date2'];
    	}

    	$sql = "
    		SELECT h.hoscode hospcode
				,h.hosname hospname
				,a.target
				,a.result
			FROM chospital_amp h
			LEFT JOIN (
				SELECT p.hospcode
					,COUNT(DISTINCT IF(p.HT_target='NOHT',p.pid,NULL)) target
					,COUNT(DISTINCT IF(p.HT_work='NOHT',p.pid,NULL)) result
				FROM (
					SELECT p.hospcode, p.pid, p.cid ,p.hn
						,CONCAT(p.name,' ',p.lname) ptname
						,TIMESTAMPDIFF(YEAR,p.birth,'$date1') age
						,p.typearea, p.nation
						,p.discharge, n.date_serv
						,n.bslevel, c.date_diag
						,IF(c.pid IS NOT NULL, 'NOHT', NULL) HT_work
						,IF(cc.pid IS NULL, 'NOHT', NULL) HT_target
					FROM person p
					LEFT JOIN ncdscreen n ON n.pid=p.pid AND n.hospcode=p.hospcode
					LEFT JOIN chronic c ON c.pid=p.pid AND c.hospcode=p.hospcode 
											AND c.chronic BETWEEN 'I10' AND 'I1599' 
											AND c.date_diag BETWEEN '$date1' AND '$date2'

					LEFT JOIN chronic cc ON cc.pid=p.pid AND cc.hospcode=p.hospcode 
											AND cc.chronic BETWEEN 'I10' AND 'I1599' 
											AND cc.date_diag < n.DATE_SERV

					WHERE TIMESTAMPDIFF(YEAR,p.birth,'$date1')>=35
							AND p.typearea IN (1,3)
							AND p.nation='099'
							AND p.discharge='9'
							AND n.date_serv BETWEEN '$date1' AND '$date2'
							AND IF(n.sbp_2 > 0,n.sbp_2,n.sbp_1) BETWEEN 130 AND 139
							AND IF(n.dbp_2 > 0,n.dbp_2,n.dbp_1) BETWEEN 80 AND 89
				) p
				GROUP BY p.hospcode
			) a ON a.hospcode=h.hoscode;";

		try{
			$rawdata = \Yii::$app->db->createCommand($sql)->queryAll();
		} catch(\yii\db\Exception $e){
			throw new \yii\web\ConflictHttpException('sql error');
		}

		$dataProvider = new \yii\data\ArrayDataProvider([
			'allModels' => $rawdata,
			'pagination' => false,
		]);

		return $this->render('report_newpt_from_preht',[
			'dataProvider' => $dataProvider,
			'date1' => $date1,
			'date2' => $date2,
			'sql' => $sql
		]);
    }

}
