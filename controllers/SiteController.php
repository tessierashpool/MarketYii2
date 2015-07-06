<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\ItemsSearch;
use app\models\Statistic;
use app\models\Items;
use app\models\Cart;
use app\models\Whishlist;
use app\models\Order;
use app\models\SignUpForm;
use app\models\Account;
use yii\web\NotFoundHttpException;

class SiteController extends Controller
{
    public $layout = "left";
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
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
        $this->layout = "left";
        $searchModel = new ItemsSearch();
        $statistic = new Statistic();
        //var_dump(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,true,12);        
        return $this->render('index',[
            'dataProvider'=>$dataProvider
        ]);
    }

    public function actionCart()
    {
        $this->layout = "right";
        return $this->render('cart');       
    }

    public function actionOrder($id)
    {
        $this->layout = "right";
        $model = $this->findOrder($id);
        return $this->render('order',['model'=>$model]);               
    }

    public function actionDetail($id)
    {
        $this->layout = "right";
        return $this->render('detail', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCheckout()
    {
        $model = new Order();
        $this->layout = "right";
        if ($model->load(Yii::$app->request->post()) && $model->saveOrder()) {
            Yii::$app->session->setFlash('newOrder');
            Cart::clearCart();
            return $this->redirect(['order', 'id' => $model->id]);
        } else {
            return $this->render('checkout',['model'=>$model]);
        }         
    }

    public function actionWhishlist()
    {
        $this->layout = "right";
        $dataProvider = Whishlist::dataProvider(); 
        return $this->render('whishlist',['dataProvider'=>$dataProvider]);
         
    }

    public function actionLogin()
    {
        $this->layout = "right"; 
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Cart::attachToUser();
            Whishlist::attachToUser();            
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionSignup()
    {
        $this->layout = "right"; 
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignUpForm();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['success-signup']);
        } else {
            return $this->render('signup', [
                'model' => $model
            ]);
        }
    }

    public function actionAccount()
    {

        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = "right";
        $model =  Account::findOne(Yii::$app->user->id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->refresh();
        } else {
            return $this->render('account',['model'=>$model]);
        }        
    }

    public function actionSuccessSignup()
    {
        $this->layout = "right"; 
        return $this->render('success-signup');
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionAjaxAddToCart($id,$scode,$sname)
    {
        $quantity = Cart::setCart($id,$scode,$sname);
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $result['id']=$id;
        $result['scode']=$scode;
        $result['sname']=$sname;
        $result['quantity']=$quantity;
        $result['totalcount']=Cart::responseCount();
        return $result;
        
    }

    public function actionAjaxGetSize($id)
    {
        $item = Items::findOne($id);
        $info = $item->info;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $result=$info['variants']['size']['listValues'];
        return $result;
        
    }

    public function actionAjaxDeleteCartItem($id,$scode)
    {
        Cart::deleteItem($id,$scode); 
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $result['totalcount']=Cart::responseCount();
        return $result;      
    }    

    public function actionAjaxChangeItemQuantity($id,$scode,$quantity)
    {
        Cart::changeQuantity($id,$scode,$quantity);  
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;  
        $result['totalcount']=Cart::responseCount();
        return $result; 
    } 

    public function actionAjaxDeleteCartAllItems()
    {
        Cart::clearCart();    
    } 

    public function actionAjaxAddToWhishlist($id)
    {
        $count = Whishlist::addToWhishlist($id); 
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $result['count']=$count;
        return $result;             
    } 

    public function actionAjaxRemoveFromWhishlist($id)
    {
        $count = Whishlist::removeFromWhishlist($id); 
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $result['count']=$count;
        return $result;              
    }

    protected function findModel($id)
    {
        if (($model = Items::findOne($id)) !== null) {
            return $model;
        } else { 
            throw new NotFoundHttpException(Yii::t('app','The requested page does not exist.'));
        }
    } 

    protected function findOrder($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }        
}
