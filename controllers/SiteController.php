<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("SELECT user_recid, first_name, last_name from user");
        $result = $command->queryAll();
        return $this->render('index', array('user' => $result));
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        return $this->render('login');
    }

    /**
     * getUser action.
     *
     * @return Response|string
     */
    public function actionGetuser()
    {
        $email = $_POST["email"];
        $login_pass =  md5($_POST["password"]);
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("SELECT 
                                                U.user_recid,
                                                U.first_name,
                                                U.last_name,
                                                U.department_id,
                                                U.user_role_id,
                                                M.first_name as mentor_first_name,
                                                M.last_name as mentor_last_name,
                                                U.email,
                                                U.position,
                                                U.salary,
                                                U.phone_number,
                                                U.start_date,
                                                D.short_name
                                             FROM user U
                                             INNER JOIN department D ON D.id = U.department_id
                                             INNER JOIN user M ON M.user_recid = U.mentor_id
                                             WHERE U.password =  '$login_pass' AND U.email = '$email' ");
       $userResult = $command->queryAll();
       $user =  $userResult[0];
      
       if($user['user_recid'] > 0){
            Yii::$app->session["user"] = $user;
            echo json_encode(array("user_recid" => $user['user_recid']));
       }else{
        Yii::$app->session["user"] = null;
        echo json_encode(array("error" => true, "message" => "Invalid username or password"));
       }
       exit;
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->session["user"] = null;

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Search action.
     *
     * @return Response|string
     */
    public function actionSearch()
    {
       $userRecid = $_POST['user_recid'];
       $connection = Yii::$app->getDb();
       $command = $connection->createCommand("SELECT 
                                                U.user_recid,
                                                U.first_name,
                                                U.last_name,
                                                U.department_id,
                                                M.first_name as mentor_first_name,
                                                M.last_name as mentor_last_name,
                                                U.email,
                                                U.position,
                                                U.salary,
                                                U.phone_number,
                                                U.start_date,
                                                D.short_name
                                             FROM user U
                                             INNER JOIN department D ON D.id = U.department_id
                                             INNER JOIN user M ON M.user_recid = U.mentor_id
                                             WHERE U.user_recid =  $userRecid");
       $userResult = $command->queryAll();
       $departmentID =  $userResult[0]['department_id'];
       $command = $connection->createCommand("SELECT 
            U.user_recid,
            U.first_name,
            U.last_name
            FROM user U
            WHERE U.department_id =  $departmentID 
            AND U.user_recid <> $userRecid");

        $teamsResult = $command->queryAll();
       echo json_encode(array("user" => $userResult, 'team' => $teamsResult));
       exit;
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionDashboard()
    {
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("SELECT user_recid, first_name, last_name from user");
        $result = $command->queryAll();
        return $this->render('dashboard', array('user' => $result));
    }

    /**
     * Submitapplication action.
     *
     * @return Response|string
     */
    public function actionSubmitapplication()
    {
        $user_recid = $_POST["user_recid"];
        $appstatus =  $_POST["appstatus"];
        $description = $_POST["description"];
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand(" INSERT INTO application (start_date, last_update, status, description, account_id)
                                                VALUES(NOW(), NOW(), '$appstatus', '$description', $user_recid  ); ");
        
        if($command->execute()){
            echo json_encode(array("status" => true));
        }else{
            Yii::$app->session["user"] = null;
            echo json_encode(array("status" => false));
        }
       exit;
    }

    /**
     * Submitapplication action.
     *
     * @return Response|string
     */
    public function actionApplications()
    {

        $status = "";
        if(Yii::$app->session["user"]["position"] == 'Hr Specialist'){
            $status = "rejected";
        }else{
            $status = "approved";
        }
    
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand(" SELECT * from application WHERE status = '$status' ");
        $result = $command->queryAll();
        return $this->render('application', array('applications' => $result));
        
    }

    /**
     * Editapplication action.
     *
     * @return Response|string
     */
    public function actionEditapplication()
    {
        $app_id = $_POST["app_id"];
        $description = $_POST["description"];
        $hr_comment = $_POST["hr_comment"];
        $manager_comment = $_POST["manager_comment"];
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand(" UPDATE application SET 
                                                                    last_update = NOW(),
                                                                    description = '$description',
                                                                    hr_comment = '$hr_comment',
                                                                    manager_comment = '$manager_comment',
                                                                    status = 'closed'
                                                    WHERE application_id = $app_id
                                            ");
        
        if($command->execute()){
            echo json_encode(array("status" => true));
        }else{
            Yii::$app->session["user"] = null;
            echo json_encode(array("status" => false));
        }
       exit;
    }
}
