<?php

namespace frontend\controllers;

use Yii;
use frontend\models\UploadFortythree;
use frontend\models\UploadFortythreeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * UploadFortythreeController implements the CRUD actions for UploadFortythree model.
 */
class UploadFortythreeController extends Controller
{

    public $enableCsrfValidation = false;
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all UploadFortythree models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UploadFortythreeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UploadFortythree model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UploadFortythree model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UploadFortythree();

        if ($model->load(Yii::$app->request->post())) {
            $uploadFile = UploadedFile::getInstance($model, 'file');
            if(!$uploadFile){
                return $this->render('create',['model' => $model]);
            }
            $hos ='-';
            $hospcode = explode("_", $uploadFile->baseName);
            if(strtoupper($hospcode[1]) === 'F43'){
                $hos = $hospcode[2];
            }else{
                $hos = $hospcode[1];
            }
            $model->hospcode = $hos;
            $filename = $uploadFile->baseName . ".".$uploadFile->extension;
            $model->file_name = $filename;
            $model->file_size = strval(number_format($uploadFile->size/(1024*1024),3));
            $model->note1 = $uploadFile->baseName;
            $model->note2 = 'รอการนำเข้า';
            $model->save();


            $path = './fortythree/';
            $pathbackup = './fortythreebackup/';
            $uploadFile->saveAs($path . $filename);
            copy($path . $filename, $pathbackup . $filename);


            return $this->redirect(['view', 'id' => $model->id]);

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing UploadFortythree model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing UploadFortythree model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UploadFortythree model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UploadFortythree the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UploadFortythree::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDetail($filename, $upload_date, $upload_time) {

        $model = \frontend\models\SysCountImport::find()
                ->where(['filename' => $filename,
                    'upload_date' => $upload_date,
                    'upload_time' => $upload_time])
                ->one();
        if ($model) {

            return $this->render('detail', [
                        'model' => $model,
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
      public function actionDetail2($filename) {

        $model = \frontend\models\SysCountImport::find()
                ->where(['filename' => $filename])
                ->one();
        if ($model) {

            return $this->render('detail2', [
                        'model' => $model,
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionImportall(){
        return $this->render('importall');
    }
}
