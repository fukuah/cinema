<?php

namespace app\controllers;

use app\models\CinemaSession;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Order;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'order-ticket', 'order-tickets'],
                'rules' => [
                    [
                        'actions' => ['logout', 'order-ticket', 'order-tickets'],
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
        return $this->render('index');
    }

    public function actionOrderTickets(){
        $dataProvider = new ActiveDataProvider([
            'query' => $model = CinemaSession::find()->where(['>','time_start', date("Y-m-d H:i:s")])
        ]);

        return $this->render('order-ticket', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionOrderTicket($id, $row, $col){
        $order = Order::findOne(['session_id' => $id, 'row' => $row, 'col' => $col]);

        $session = CinemaSession::find()->where(['id' => $id])->andWhere(['>','time_start', date("Y-m-d H:i:s")])->one();
        if(!isset($session->id)){
            return 'Сеанс не существует или заказ билетов на него завершен';
        }

        if(isset($order->id)){
            return 'место уже занято';
        } else {
            if(
                ($row < 1 || $row > $session->hall->seat_row)
                || ($col < 1 || $col > $session->hall->seat_col)) {
                return 'Указанного места не существует, проверьте заказ';
            }
            $order = new Order();
            $order->attributes = [
                'session_id' => $id,
                'row' => $row,
                'col' => $col,
                'hall_id' => $session->cinema_hall_id,
                'user_id' => Yii::$app->user->identity->id,
            ];
            $order->save();
            return 'место забронировано';
        }
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

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
}
