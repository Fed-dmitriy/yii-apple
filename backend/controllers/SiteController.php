<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use backend\models\Apple;//подключаем модель Apple
use backend\services\AppleService; //в данном классе помещена логика обработки действий над яблоками
use backend\services\AppleActionMessage;// класс, который содержит основные сообщения, отправляемые пользователю при совершенни действий с яблоками
use backend\services\EatResult; //в данном классе обрабатывается результаты действия "съесть яблоко", чтобы в т.ч. упростить читабельность actionEate

/**
 * Site controller
 */
//$appleService = new AppleService();
class SiteController extends Controller
{
    /**
     * @var AppleService
     */
    /**
     * помещаем класс AppleService в конструктор для дальнейшего автоматического создания экземпляра класса
     */
    protected $appleService;

    public function __construct($id, $module, AppleService $appleService, $config = [])
    {
        $this->appleService = $appleService;
        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout',
                            'index',
                            'delete-apples-all',
                            'generate',
                            'fall-to-ground',
                            'delete-apple-one',
                            'eate',
                            'change-color'
                        ],
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */

    //генерация яблок в случайном количестве, случайном цвете
    public function actionGenerate()
    {
        if ($this->appleService->generate()){
            Yii::$app->session->setFlash('success', AppleActionMessage::GENERATE_SUCCESS);
        }
        return $this->redirect(['index']);
    }
    //удаление всех яблок
    public function actionDeleteApplesAll()
    {
        if ($this->appleService->deleteApplesAll()){
            Yii::$app->session->setFlash('success', AppleActionMessage::DELETE_ALL_SUCCESS);
        }else{
            Yii::$app->session->setFlash('danger', AppleActionMessage::DELETE_ALL_ERROR);
        }
        return $this->redirect(['site/index']);
    }
    //удалить одно выбранное яблоко
    public function actionDeleteAppleOne()
    {
        $request = Yii::$app->request;
        $id = Yii::$app->request->get('deleteAppleOne');
        $this->appleService->spoiledApple();
        if ($this->appleService->deleteAppleOne($id)){
            Yii::$app->session->setFlash('success', AppleActionMessage::DELETE_ONE_SUCCESS);
        }else{
            Yii::$app->session->setFlash('danger', AppleActionMessage::DELETE_ONE_ERROR);
        }
        return $this->redirect(['index']);
    }
    //уронить яблоко на землю
    public function actionFallToGround()
    {
        $id = Yii::$app->request->get('fallToGround');
        $this->appleService->spoiledApple();
        if ($this->appleService->fallToGround($id)==true){
            Yii::$app->session->setFlash('success', AppleActionMessage::FALL_To_GROUND_SUCCESS);
        }else{
            Yii::$app->session->setFlash('danger', AppleActionMessage::ALREADY_ON_GROUND);
        }
        return $this->redirect(['index']);
    }
    //изменить цвет яблока
    public function actionChangeColor()
    {
        if (Yii::$app->getRequest()->isPost) {
            $id = Yii::$app->request->post('Apple')['id'];
            $changeColor = Yii::$app->request->post('Apple')['change_color'];
            $this->appleService->spoiledApple();
            if ($this->appleService->changeColor($id, $changeColor)){
                Yii::$app->session->setFlash('success', AppleActionMessage::CHANGE_COLOR_SUCCESS);
            }
        }
        return $this->redirect(['index']);
    }
    //съесть яблоко
    public function actionEate()
    {
        if (Yii::$app->getRequest()->isPost) {
            $id = Yii::$app->request->post('Apple')['id'];
            $persantageEaten = Yii::$app->request->post('Apple')['percentage_eaten'];
            $this->appleService->spoiledApple();
            $result = new EatResult();
            $result->setResult($id, $persantageEaten);
            $result->setMessage();
        }
        return $this->redirect(['index']);
    }


    public function actionIndex()
    {
        $apples = Apple::find()->all();
        return $this->render('index', ['apples' => $apples]);
    }



    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
