<?php

namespace backend\controllers;

class ImportDataController extends \yii\web\Controller {

    public $enableCsrfValidation = false;

    public function actionIndex() {
        $hospname = '';
        $rawData1 = '';
        $sql = "select mapp_table,mapp_query from data_hinfo.mas_mapp_main";

        if (!empty($_POST['hospcode'])) {
            $h = $_POST['hospcode'];
            $m = \frontend\models\ChospitalAmp::findOne(['hoscode' => $h]);
            $hospname = $m->hosname;
        }
        try {
            $rawData = \Yii::$app->db2->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $count = count($rawData);
        if (!empty($_POST['hospcode'])) {
            $dbname = 'db' . $_POST['hospcode'];
            //$db2 = 'db';
            for ($i = 0; $i < 1; $i++) {
                $sql_command = $rawData[$i]['mapp_query'];
                $table = $rawData[$i]['mapp_table'];
                $table = 'tmp_' . $table;
                $sql = "truncate $table";
                try {
                    $count_exe = \Yii::$app->db->createCommand($sql)->execute();
                } catch (\yii\db\Exception $e) {
                    throw new \yii\web\ConflictHttpException('sql error');
                }
                $sql = $sql_command;
                try {
                    $rawData1 = \Yii::$app->$dbname->createCommand($sql)->queryAll();
                } catch (\yii\db\Exception $e) {
                    throw new \yii\web\ConflictHttpException('sql error');
                }
                $sql = "replace into $table select * from person";
                try {
                    $exe = \Yii::$app->db->createCommand($sql)->execute();
                } catch (\yii\db\Exception $e) {
                    throw new \yii\web\ConflictHttpException('sql error');
                }
            }
        }
        return $this->render('index', [
                    'hospname' => $hospname,
                    'hospcode' => isset($_POST['hospcode']) ? $_POST['hospcode'] : '',
                    'count' => $count,
                    'rawData' => $rawData,
                    'rawData1' => $rawData1
        ]);
    }

    protected function call($store_name, $arg = NULL) {
        $sql = "";
        if ($arg != NULL) {
            $sql = "call " . $store_name . "(" . $arg . ");";
        } else {
            $sql = "call " . $store_name . "();";
        }
        $this->exec_sql($sql);
    }

    protected function call2($store_name, $arg1 = NULL, $arg2 = NULL) {
        $sql = "";
        $arg1 = "'" . $arg1 . "'";
        if ($arg1 != NULL and $arg2 != NULL) {
            $sql = 'call ' . $store_name . '(' . $arg1 . ')';
        }
        $this->exec_sql_db($sql, $arg2);
    }

    protected function exec_sql($sql, $db) {
        if ($db == 1) {
            $affect_row = \Yii::$app->db->createCommand($sql)->execute();
        } else {
            $affect_row = \Yii::$app->db2->createCommand($sql)->execute();
        }
        return $affect_row;
    }

    protected function exec_sql_db($sql, $db) {
        $affect_row = \Yii::$app->$db->createCommand($sql)->execute();
        return $affect_row;
    }

    protected function query_all($sql) {
        $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        return $rawData;
    }

    protected function query_all_db2($sql) {
        $rawData = \Yii::$app->db2->createCommand($sql)->queryAll();
        return $rawData;
    }

    public function actionGeneratorperson() {
        $sql = "select hoscode from chospital_amp where already = 1";
        $rawData = $this->query_all_db2($sql);

        $sql = "select * from mas_mapp_main where OID = 1";
        $mapData = $this->query_all_db2($sql);

        $sql = "truncate f43_person";
        $this->exec_sql($sql, 2);
        //person
        foreach ($rawData as $data) {
            $db_name = 'jhcisdb_' . $data['hoscode'];
            $db = 'db' . $data['hoscode'];
            
            $sql = "call create_f43_table_person()";
            $this->exec_sql_db($sql, $db);

            if ($data['hoscode'] == '11241') {
                $sql = "call replace_into_table()";
                $this->exec_sql($sql, 2);
            } else {
                $table = $mapData['0']['MAIN_TABLE'];
                $DATE_START = $mapData['0']['DATESTART'];
                $DATE_END = $mapData['0']['DATEEND'];
                $mapp_sql = $mapData['0']['MAPP_QUERY'];
                //$del_flag = $mapData['0']['DELETE_FLAG'];
                //$table_ver = $mapData['0']['MAPP_TABLE_VER'];
                //var_dump($mapp_sql);
                //die();
                //
                //generate data from jhcis version to f43 version
                $sql = "call cal_table_tmp_newver1(\"" . $table . "\",\"(" . $mapp_sql . ")\",\"" . $DATE_START . "\",\"" . $DATE_END . "\")";
                $this->exec_sql_db($sql, $db);

                //insert f43 from jhcis database to 43f_generate database
                $sql = "call replace_into_table('$db_name','$table')";
                $this->exec_sql($sql, 2);

                //drop f43 table in jhcis database
                $sql = "call cal_table_tmp_drop('$table','$db_name')";
                $this->exec_sql($sql, 2);
            }
        }
        return $table;
    }
    
    //Generate cumulative type
    public function actionGenfcumulative() {
        //find hoscode from chospital_amp table
        $sql = "select hoscode from chospital_amp where already = 1";
        $hosData = $this->query_all_db2($sql);

        //find cumulative table from mas_mapp_main table with comment value 1
        $sql = "select * from mas_mapp_main where comment = 1";
        $cuTable = $this->query_all_db2($sql);

        foreach ($cuTable as $cData) {
            $table = $cData['MAIN_TABLE'];
            $sql = "truncate $table";
            $this->exec_sql($sql, 2);
        }

        foreach ($hosData as $hData) {
            $db_name = 'jhcisdb_' . $hData['hoscode'];
            $db = 'db' . $hData['hoscode'];
            
            $sql = "call create_f43_cumulative_table()";
            $this->exec_sql_db($sql, $db);
            
            foreach ($cuTable as $cData) {
                $table = $cData['MAIN_TABLE'];
                $DATE_START = $cData['DATESTART'];
                $DATE_END = $cData['DATEEND'];
                $mapp_sql = $cData['MAPP_QUERY'];

                //$sql = "truncate $table";
                //$this->exec_sql_db($sql, $db);

                

                //generate data from jhcis version to f43 version
                $sql = "call cal_table_tmp_newver1(\"" . $table . "\",\"(" . $mapp_sql . ")\",\"" . $DATE_START . "\",\"" . $DATE_END . "\")";
                //$sql ="call cal_table_tmp_newver2($table,$mapp_sql)";
                $this->exec_sql_db($sql, $db);

                //insert f43 from jhcis database to 43f_generate database
                $sql = "call replace_into_table('$db_name','$table')";
                $this->exec_sql($sql, 2);

                //drop f43 table in jhcis database
                //$sql = "call cal_table_tmp_drop('$table','$db_name')";
                //$this->exec_sql($sql,2);
            }
        }

        return 'Cumulative';
    }

    //Generate services type
    public function actionGenfservice() {
        //find hoscode from chospital_amp table
        //$sql = "select hoscode from chospital_amp where already = 1";
        $sql = "select hoscode from chospital_amp where already = 1";
        $hosData = $this->query_all_db2($sql);

        //find cumulative table from mas_mapp_main table with comment value 2
        $sql = "select * from mas_mapp_main where comment = 2";
        $cuTable = $this->query_all_db2($sql);

        foreach ($cuTable as $cData) {
            $table = $cData['MAIN_TABLE'];
            $sql = "truncate $table";
            $this->exec_sql($sql, 2);
        }

        foreach ($hosData as $hData) {
            $db_name = 'jhcisdb_' . $hData['hoscode'];
            $db = 'db' . $hData['hoscode'];
            
            $sql = "call create_f43_service_table()";
            $this->exec_sql_db($sql, $db);
            
            foreach ($cuTable as $cData) {
                $table = $cData['MAIN_TABLE'];
                $DATE_START = $cData['DATESTART'];
                $DATE_END = $cData['DATEEND'];
                $mapp_sql = trim($cData['MAPP_QUERY']);

                if ($table == 'f43_dental') {
                    $sql = "call cal_table_dental_tmp('$table')";
                    $this->exec_sql_db($sql, $db);
                }else if($table == 'f43_appointment'){
                    $sql = "call cal_table_appointment_tmp('$table')";
                    $this->exec_sql_db($sql, $db);
                }else {
                    //generate data from jhcis version to f43 version
                    $sql = "call cal_table_tmp_newver1(\"" . $table . "\",\"(" . $mapp_sql . ")\",\"" . $DATE_START . "\",\"" . $DATE_END . "\")";
                    $this->exec_sql_db($sql, $db);
                }

                //insert f43 from jhcis database to 43f_generate database
                $sql = "call replace_into_table('$db_name','$table')";
                $this->exec_sql($sql, 2);

                //drop f43 table in jhcis database
                //$sql = "call cal_table_tmp_drop('$table','$db_name')";
                //$this->exec_sql($sql, 2);
            }
        }

        return 'Services';
    }

    public function actionGeneratorall() {
        //find hoscode from chospital_amp table
        //$sql = "select hoscode from chospital_amp where already = 1";
        $sql = "select hoscode from chospital_amp where already = 1";
        $hosData = $this->query_all_db2($sql);

        //find cumulative table from mas_mapp_main table with comment value 2
        $sql = "select * from mas_mapp_main";
        $cuTable = $this->query_all_db2($sql);

        foreach ($cuTable as $cData) {
            $table = $cData['MAIN_TABLE'];
            $sql = "truncate $table";
            $this->exec_sql($sql, 2);
        }

        foreach ($hosData as $hData) {
            $db_name = 'jhcisdb_' . $hData['hoscode'];
            $db = 'db' . $hData['hoscode'];
            
            $sql = "call create_f43_table()";
            $this->exec_sql_db($sql, $db);
            
            foreach ($cuTable as $cData) {
                $table = $cData['MAIN_TABLE'];
                $DATE_START = $cData['DATESTART'];
                $DATE_END = $cData['DATEEND'];
                $mapp_sql = trim($cData['MAPP_QUERY']);

                if ($table == 'f43_dental') {
                    $sql = "call cal_table_dental_tmp('$table')";
                    $this->exec_sql_db($sql, $db);
                }else if($table == 'f43_appointment'){
                    $sql = "call cal_table_appointment_tmp('$table')";
                    $this->exec_sql_db($sql, $db);
                }else {
                    //generate data from jhcis version to f43 version
                    $sql = "call cal_table_tmp_newver1(\"" . $table . "\",\"(" . $mapp_sql . ")\",\"" . $DATE_START . "\",\"" . $DATE_END . "\")";
                    $this->exec_sql_db($sql, $db);
                }

                //insert f43 from jhcis database to 43f_generate database
                $sql = "call replace_into_table('$db_name','$table')";
                $this->exec_sql($sql, 2);

                //drop f43 table in jhcis database
                //$sql = "call cal_table_tmp_drop('$table','$db_name')";
                //$this->exec_sql($sql, 2);
            }
        }

        return 'All';
    }

}
