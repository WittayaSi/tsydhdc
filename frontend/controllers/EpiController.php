<?php

namespace frontend\controllers;
use yii;

class EpiController extends \yii\web\Controller
{
	public $enableCsrfValidation = false;

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionReportbcg(){
    	$timestamp_pre = strtotime('-2 years');
        $timestamp = strtotime('-1 years');
    	$date1 = date('Y-m-d',$timestamp_pre);
    	$date2 = date('Y-m-d',$timestamp);
    	//$bdg_date = '2014-03-31';

    	if(Yii::$app->request->isPost){
    		$date1 = $_POST['date1'];
    		$date2 = $_POST['date2'];
    	}

    	$sql = "
    	select h.hoscode as hospcode, h.hosname as hospname,
    	(select count_target from( 
    		select p.hospcode, count(distinct p.pid) as count_target
    		from person p
    		where p.discharge = '9' and p.typearea in (1,3) and p.nation = '099'
    			  and (p.birth between '$date1' and '$date2')
    		group by p.hospcode ) as t
		where t.hospcode = h.hoscode
		) as target,
		(select count_result from(
			select p.hospcode, count(distinct p.pid) as count_result
			from epi e left join person p on(e.hospcode = p.hospcode and e.pid = p.pid)	
			where p.discharge = '9' and p.typearea in (1,3) and p.nation = '099'
				  and (p.birth between '$date1' and '$date2') and e.vaccinetype = '010' 
			group by p.hospcode) as r
		where r.hospcode = h.hoscode
		) as result
		from chospital_amp h
		order by distcode, hoscode asc;";
    	try{
    		$rawdata = \Yii::$app->db->createCommand($sql)->queryAll();
    	} catch (\yii\db\Exception $e){
    		throw new \yii\web\ConflictHttpException('sql error');
    	}

    	$dataProvider = new \yii\data\ArrayDataProvider([
    		'allModels' => $rawdata,
    		'pagination' => false
    	]);

    	return $this->render('reportbcg',[
    		'dataProvider' => $dataProvider,
    		'date1' => $date1,
    		'date2' => $date2,
    		'sql' => $sql
    	]);
    }


    public function actionIndivReportBcg($hospcode = null, $date1 = '2014-10-01', $date2 = '2015-09-30')
    {
        $sql = "
        select distinct p.hospcode
            ,p.pid
            ,concat(p.name,' ',p.lname) as fullname
            ,if(p.sex=1,'ชาย','หญิง') as sex
            ,ifnull(TIMESTAMPDIFF(MONTH,p.birth,e.date_serv),0) as age_m
            ,e.date_serv
            ,if(
                (select count(*) 
                from epi e 
                where e.vaccinetype = '010' 
                    and concat(e.pid,e.hospcode) = concat(p.pid,p.hospcode)
                )>0,'y','n') as result
        from person p
        left join epi e on(p.pid = e.pid and p.hospcode = e.hospcode)
        where p.discharge = '9'
            and p.typearea in ('1','3')
            and p.nation = '099'
            and p.hospcode = '$hospcode'
            and (p.birth BETWEEN '$date1' and '$date2')
        group by p.hospcode, p.pid
        order by p.pid
        ";

        //$rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        try{
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e){
            throw new \yii\web\ConflictHttpException('sql error');
        }

        return $this->render('indiv_report_bcg',[
            'rawData' => $rawData,
            'date1' => $date1,
            'date2' => $date2,
            'sql' => $sql
        ]);
    }

    public function actionReportmmr(){
    	$timestamp_pre = strtotime('-2 years');
        $timestamp = strtotime('-1 years');
        $date1 = date('Y-m-d',$timestamp_pre);
        $date2 = date('Y-m-d',$timestamp);
    	//$bdg_date = '2014-03-31';

    	if(Yii::$app->request->isPost){
    		$date1 = $_POST['date1'];
    		$date2 = $_POST['date2'];
    	}

    	$sql = "
    	select h.hoscode as hospcode, h.hosname as hospname,
    	(select count_target from( 
    		select p.hospcode, count(distinct p.pid) as count_target
    		from person p
    		where p.discharge = '9' and p.typearea in (1,3) and p.nation = '099'
    			  and (p.birth between '$date1' and '$date2')
    		group by p.hospcode ) as t
		where t.hospcode = h.hoscode
		) as target,
		(select count_result from(
			select p.hospcode, count(distinct p.pid) as count_result
			from epi e left join person p on(e.hospcode = p.hospcode and e.pid = p.pid)	
			where p.discharge = '9' and p.typearea in (1,3) and p.nation = '099'
				  and (p.birth between '$date1' and '$date2') and e.vaccinetype = '061' 
			group by p.hospcode) as r
		where r.hospcode = h.hoscode
		) as result
		from chospital_amp h
		order by distcode, hoscode asc;";
    	try{
    		$rawdata = \Yii::$app->db->createCommand($sql)->queryAll();
    	} catch (\yii\db\Exception $e){
    		throw new \yii\web\ConflictHttpException('sql error');
    	}

    	$dataProvider = new \yii\data\ArrayDataProvider([
    		'allModels' => $rawdata,
    		'pagination' => false
    	]);

    	return $this->render('reportmmr',[
    		'dataProvider' => $dataProvider,
    		'date1' => $date1,
    		'date2' => $date2,
    		'sql' => $sql
    	]);
    }


    public function actionIndivReportMmr($hospcode = null, $date1 = '2014-10-01', $date2 = '2015-09-30')
    {
        $sql = "
        select distinct p.hospcode
            ,p.pid
            ,concat(p.name,' ',p.lname) as fullname
            ,if(p.sex=1,'ชาย','หญิง') as sex
            ,ifnull(TIMESTAMPDIFF(MONTH,p.birth,e.date_serv),0) as age_m
            ,e.date_serv
            ,if(
                (select count(*) 
                from epi e 
                where e.vaccinetype = '061' 
                    and concat(e.pid,e.hospcode) = concat(p.pid,p.hospcode)
                )>0,'y','n') as result
        from person p
        left join epi e on(p.pid = e.pid and p.hospcode = e.hospcode)
        where p.discharge = '9'
            and p.typearea in ('1','3')
            and p.nation = '099'
            and p.hospcode = '$hospcode'
            and (p.birth BETWEEN '$date1' and '$date2')
        group by p.hospcode, p.pid
        order by p.pid
        ";

        //$rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        try{
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e){
            throw new \yii\web\ConflictHttpException('sql error');
        }

        return $this->render('indiv_report_mmr',[
            'rawData' => $rawData,
            'date1' => $date1,
            'date2' => $date2,
            'sql' => $sql
        ]);
    }

    public function actionReportdtp5(){
    	$timestamp_pre = strtotime('-6 years');
        $timestamp = strtotime('-5 years');
        $date1 = date('Y-m-d',$timestamp_pre);
        $date2 = date('Y-m-d',$timestamp);
    	$bdg_date = '2014-03-31';

    	if(Yii::$app->request->isPost){
    		$date1 = $_POST['date1'];
    		$date2 = $_POST['date2'];
    	}

    	$sql = "
    	select h.hoscode as hospcode, h.hosname as hospname,
    	(select count_target from( 
    		select p.hospcode, count(distinct p.pid) as count_target
    		from person p
    		where p.discharge = '9' and p.typearea in (1,3) and p.nation = '099'
    			  and (p.birth between '$date1' and '$date2')
    		group by p.hospcode ) as t
		where t.hospcode = h.hoscode
		) as target,
		(select count_result from(
			select p.hospcode, count(distinct p.pid) as count_result
			from epi e left join person p on(e.hospcode = p.hospcode and e.pid = p.pid)	
			where p.discharge = '9' and p.typearea in (1,3) and p.nation = '099'
				  and (p.birth between '$date1' and '$date2') and e.vaccinetype = '035' 
			group by p.hospcode) as r
		where r.hospcode = h.hoscode
		) as result
		from chospital_amp h
		order by distcode, hoscode asc;";
    	try{
    		$rawdata = \Yii::$app->db->createCommand($sql)->queryAll();
    	} catch (\yii\db\Exception $e){
    		throw new \yii\web\ConflictHttpException('sql error');
    	}

    	$dataProvider = new \yii\data\ArrayDataProvider([
    		'allModels' => $rawdata,
    		'pagination' => false
    	]);

    	return $this->render('reportdtp5',[
    		'dataProvider' => $dataProvider,
    		'date1' => $date1,
    		'date2' => $date2,
    		'sql' => $sql
    	]);
    }

    public function actionIndivReportDTP5($hospcode = null, $date1 = '2014-10-01', $date2 = '2015-09-30')
    {
        $sql = "
        select distinct p.hospcode
            ,p.pid
            ,concat(p.name,' ',p.lname) as fullname
            ,if(p.sex=1,'ชาย','หญิง') as sex
            ,ifnull(TIMESTAMPDIFF(MONTH,p.birth,e.date_serv),0) as age_m
            ,e.date_serv
            ,if(
                (select count(*) 
                from epi e 
                where e.vaccinetype = '035' 
                    and concat(e.pid,e.hospcode) = concat(p.pid,p.hospcode)
                )>0,'y','n') as result
        from person p
        left join epi e on(p.pid = e.pid and p.hospcode = e.hospcode)
        where p.discharge = '9'
            and p.typearea in ('1','3')
            and p.nation = '099'
            and p.hospcode = '$hospcode'
            and (p.birth BETWEEN '$date1' and '$date2')
        group by p.hospcode, p.pid
        order by p.pid
        ";

        //$rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        try{
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e){
            throw new \yii\web\ConflictHttpException('sql error');
        }

        return $this->render('indiv_report_dtp5',[
            'rawData' => $rawData,
            'date1' => $date1,
            'date2' => $date2,
            'sql' => $sql
        ]);
    }

}
