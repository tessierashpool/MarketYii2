<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Items;
use app\models\ItemsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Categories;
use yii\helpers\ArrayHelper;

/**
 * ItemsController implements the CRUD actions for Items model.
 */
class ItemsController extends Controller
{
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
     * Lists all Items models.
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new ItemsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $categoryModel = $this->findCategory(Yii::$app->request->get('category_id'));
        $arCategories = $categoryModel->namesArray;
        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categoryModel' => $categoryModel,
            'arCategories' => $arCategories,
        ]);
    }

    public function actionIndex()
    {
        $model = new Categories();
        $dataTree = $model->getTree();

        return $this->render('index', [
            'model' => $model,
            'dataTree' => $dataTree,
        ]);
    }

    /**
     * Displays a single Items model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $categoryModel = $this->findCategory($model->category_id);
        return $this->render('view', [
            'model' => $model,
            'categoryModel' => $categoryModel,
        ]);
    }

    /**
     * Creates a new Items model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Items();
        $categoryModel = $this->findCategory(Yii::$app->request->get('category_id'));
        
        if ($model->load(Yii::$app->request->post()) && $model->saveItem()) {
            return $this->redirect(['list', 'category_id' => $model->category_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'categoryModel' => $categoryModel,
            ]);
        }
    }

    /**
     * Updates an existing Items model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $categoryModel = $this->findCategory(Yii::$app->request->get('category_id'));
        if ($model->load(Yii::$app->request->post()) && $model->saveItem()) {
            return $this->redirect(['list', 'category_id' => $model->category_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'categoryModel' => $categoryModel,
            ]);
        }
    }

    /**
     * Deletes an existing Items model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->deleteItem();

        return $this->redirect(['list','category_id'=>$model->category_id]);
    }

    public function actionDeleteAll()
    {
        $arIds = Yii::$app->request->post('ids');
        if(count($arIds)>0)
        {
            $model = $this->findModel($arIds[0]);
            foreach($arIds as $id)
                $this->findModel($id)->deleteItem();
            return $this->redirect(['list','category_id'=>$model->category_id]);
        }
        else
        {
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the Items model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Items the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Items::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findCategory($id)
    {
        if (($model = Categories::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }   
}
