<?php
/**
 * Created by PhpStorm.
 * User: Aleksei
 * Date: 29.01.2019
 * Time: 10:29
 */

namespace app\controllers;


use app\models\CinemaSession;
use app\models\Cinema;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;

class AdminController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['add-session', 'add-cinema', 'edit-session', 'edit-cinema'],
                'rules' => [
                    [
                        'actions' => ['add-session', 'add-cinema', 'edit-session', 'edit-cinema'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->is_admin;
                        }
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

    public function actionAddSession(){
        $model = new CinemaSession();

        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post())){
            $model->save();
        } else if (Yii::$app->request->isPost) {
            print_r($model->errors);
            exit;
        }

        return $this->render('add-session', [
            'model' => $model
        ]);
    }

    public function actionAddCinema(){
        $model = new Cinema();

        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post())){
            $model->save();
        } else if (Yii::$app->request->isPost) {
            print_r($model->errors);
            exit;
        }

        return $this->render('add-cinema', [
            'model' => $model
        ]);
    }

    public function actionEditCinema($id){
        $model = Cinema::findOne($id);

        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post())){
            $model->save();
        } else if (Yii::$app->request->isPost) {
            print_r($model->errors);
            exit;
        }

        if(!isset($model->id)){
            throw new \yii\web\NotFoundHttpException();
        }

        return $this->render('add-cinema', [
            'model' => $model
        ]);
    }

    public function actionEditSession($id){
        $model = CinemaSession::findOne($id);

        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post())){
            $model->save();
        } else if (Yii::$app->request->isPost) {
            print_r($model->errors);
            exit;
        }

        if(!isset($model->id)){
            throw new \yii\web\NotFoundHttpException();
        }

        return $this->render('add-session', [
            'model' => $model
        ]);
    }
}