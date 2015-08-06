<?php

namespace backend\controllers;

use yii;
use backend\models\SysMonth;
use backend\models\SysCheckProcess;
use backend\models\SysProcessRunning;
use yii\data\ArrayDataProvider;

class ProcessController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $server_time = date('Y-m-d H:i:s');
        $check_process = SysCheckProcess::find()->one();
        $process_name = $check_process->fnc_name;
        $process_time = $check_process->time;

        $sql = "show processlist;";
        $all_process = \Yii::$app->db->createCommand($sql)->queryAll();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $all_process,
            'sort' => count($all_process) > 0 ? ['attributes' => array_keys($all_process[0])] : [],
            'pagination' => false,
        ]);

        if(Yii::$app->request->isPjax){
            return $this->renderAjax('index',[
                'dataProvider' => $dataProvider,
                'server_time' => $server_time,
                'process_name' => $process_name,
                'process_time' => $process_time,
            ]);
        }

        return $this->render('index',[
            'dataProvider' => $dataProvider,
            'server_time' => $server_time,
            'process_name' => $process_name,
            'process_time' => $process_time,
        ]);
    }

    public function actionProcessdata()
    {
        $this->call("truncate_table",NULL);
        $running = SysProcessRunning::find()->one();
        $running = $running->running;
        if($running === 'false'){
            $this->call("start_process", NULL);
        	$month = SysMonth::find()->all();
        	foreach ($month as $vm) {
        		if($vm->month <= date('Ym')){
        			$sql = "call cal_sys_count_all($vm->month,$vm->selyear)";
        			$this->execute_sql($sql);
        		}
        	}
            $this->call("end_process", NULL);
        }
    }

    public function actionProcessreport()
    {
        $running = SysProcessRunning::find()->one();

        
        if($running->running === 'false'){

            $bgd = "'2014-04-01'";

            $this->call("start_process", NULL);

            $this->call("call_all_run_report_process", $bgd);

            $this->call("end_process", NULL);

        }
    }

    private function call($store_name, $arg = NULL){
        $sql ='';
        if($arg != NULL){
            $sql = "call " . $store_name . "(" . $arg . ");";
        }else{
            $sql = "call " . $store_name . "();";
        }
        $this->execute_sql($sql);
    }

    private function execute_sql($sql)
    {
    	$affect_row = \Yii::$app->db->createCommand($sql)->execute();
    	return $affect_row;
    }

}
