<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\MarketFixtures;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class FixturesController extends Controller
{
   

    /**
     * Displays a single Categories model.
     * @param integer $id
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new MarketFixtures();     
       // $model->addCategoriesToDB();  
        return $this->render('index', [
            'model' => $model
        ]);
    }

    public function actionCreateParameters()
    {
        $model = new MarketFixtures();     
        $model->addParamsToDB();  
        return $this->redirect(['index']);
    }    

    public function actionCreateCategories()
    {
        $model = new MarketFixtures();     
        $model->addCategoriesToDB();  
        return $this->redirect(['index']);
    }  

    public function actionCreateItems()
    {
        $model = new MarketFixtures();     
        $model->addItemsToDB();  
        return $this->redirect(['index']);
    }

    public function actionTruncateAll()
    {
        $model = new MarketFixtures();     
        $model->truncateAll();  
        return $this->redirect(['index']);
    }   

     public function actionTruncateItems()
    {
        $model = new MarketFixtures();     
        $model->truncateItems();  
        return $this->redirect(['index']);
    }     
}
