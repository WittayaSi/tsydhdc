<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\Models\ChospitalAmp;
use frontend\Controllers\GuageController;
use yii\helpers\Url;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */

    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $data = '';
        $value = '';
        $hosname ='';
        //$model = new ChospitalAmp;

        if(!empty($_POST['hospcode'])){
            $value = $_POST['hospcode'];
            $hosname = ChospitalAmp::findOne(['hoscode'=>$value])->hosname;
            return $this->render('index',[
                'data' => $value,
                'hospcode'=>isset($_POST['hospcode'])?$_POST['hospcode']:'',
                'hosname' => $hosname,
                //'model' => $model
            ]);
        }
        else{
            return $this->render('index',[
                'data' => $data ,
                'hospcode'=>isset($_POST['hospcode'])?$_POST['hospcode']:'',
                'hosname' => $hosname,
                //'model' => $model
            ]);
        }
    }

    public function actionDetails(){
        $get = $_GET;
        $value = base64_decode(base64_decode($get['id']));
        $title = "DTP5 details";

        $sql = "SELECT * FROM tmp_dtp5_target;";
        if($_GET['id']){
            $sql = "SELECT * FROM tmp_dtp5_target WHERE hospcode = $value;";
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


        $sql1 = "SELECT * FROM tmp_dtp5_result;";
        if($_GET['id']){
            $sql1 = "SELECT * FROM tmp_dtp5_result WHERE hospcode = $value;";
        }
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
                    'title' => $title,
        ]);
        
    }

    public function actionDetails_screen_ht(){
        $get = $_GET;
        $value = base64_decode(base64_decode($get['id']));
        $title = "Screen HT Details";
        $sql = "SELECT * FROM tmp_screen_ht_target;";
        if(!empty($value)){
            $sql = "SELECT * FROM tmp_screen_ht_target WHERE hospcode = $value;";
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

        $sql1 = "SELECT * FROM tmp_screen_ht_result;";
        if(!empty($value)){
            $sql1 = "SELECT * FROM tmp_screen_ht_result WHERE hospcode = $value;";
        }
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
                    'title' => $title,
        ]);
    }

    public function actionDetails_screen_dm(){
        $get = $_GET;
        $value = base64_decode(base64_decode($get['id']));
        $title = "Screen DM Details";
        $sql = "SELECT * FROM tmp_screen_dm_target;";
        if(!empty($value)){
            $sql = "SELECT * FROM tmp_screen_dm_target WHERE hospcode = $value;";
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

        $sql1 = "SELECT * FROM tmp_screen_dm_result;";
        if(!empty($value)){
            $sql1 = "SELECT * FROM tmp_screen_dm_result WHERE hospcode = $value;";
        }
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
                    'title' => $title,
        ]);
    }

    public function actionDetails_anc5times(){
        $get = $_GET;
        $value = base64_decode(base64_decode($get['id']));
        $title = "ANC 5 Times Details";
        $sql = "SELECT * FROM tmp_anc5times_target;";
        if(!empty($value)){
            $sql = "SELECT * FROM tmp_anc5times_target WHERE hospcode = $value;";
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

        $sql1 = "SELECT * FROM tmp_anc5times_result;";
        if(!empty($value)){
            $sql1 = "SELECT * FROM tmp_anc5times_result WHERE hospcode = $value;";
        }
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
                    'title' => $title,
        ]);
    }

    public function actionDetails_anc12wks(){
        $get = $_GET;
        $value = base64_decode(base64_decode($get['id']));
        $title = "ANC 12 Weeks Details";
        $sql = "SELECT * FROM tmp_anc12wks_target;";
        if(!empty($value)){
            $sql = "SELECT * FROM tmp_anc12wks_target WHERE hospcode = $value;";
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

        $sql1 = "SELECT * FROM tmp_anc12wks_result;";
        if(!empty($value)){
            $sql1 = "SELECT * FROM tmp_anc12wks_result WHERE hospcode = $value;";
        }
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
                    'title' => $title,
        ]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
