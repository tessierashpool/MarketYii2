<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Categories;
use app\models\ParamNames;
use app\models\CategoriesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoriesController implements the CRUD actions for Categories model.
 */
class CategoriesController extends Controller
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
     * Lists all Categories models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategoriesSearch();
        $model = new Categories();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataTree = $model->getTree();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'model' => $model,
            'dataTree' => $dataTree,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGridview()
    {
        $searchModel = new CategoriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('gridview', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateTable()
    {
        $model = new Categories();
        $dataProvider = $model->find()->select(['id','name','depth','parent_id'])->asArray()->all();;
        return $this->render('create_table', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }    

    /**
     * Displays a single Categories model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'parametersToCategories' => $model->catParameters,
            'variantsToCategories' => $model->catVariants,
        ]);
    }

    /**
     * Creates a new Categories model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Categories();
        $model->scenario = 'create';
        $parametersModel = new ParamNames();
        $this->view->params['customParam'] = Yii::$app->request->get();
        if ($model->load(Yii::$app->request->post()) && $model->saveCategory()) {
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'parametersList' => $parametersModel->allParameters,
                'variantsList' => $parametersModel->allVariants,
                'parametersToCategories' => $model->catParameters,
                'variantsToCategories' => $model->catVariants,
                'parentParameters' => $model->parentParameters,
                'parentVariants' => $model->parentVariants,
            ]);
        }
    }

    /**
     * Updates an existing Categories model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $parametersModel = new ParamNames();
        if ($model->load(Yii::$app->request->post()) && $model->saveCategory()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'parametersList' => $parametersModel->allParameters,
                'variantsList' => $parametersModel->allVariants,
                'parametersToCategories' => $model->catParameters,
                'variantsToCategories' => $model->catVariants,
                'parentParameters' => $model->parentParameters,
                'parentVariants' => $model->parentVariants,
            ]);
        }
    }

    public function actionAjaxOrderChange($id1,$id2)
    {
        $model = new Categories();
        $category1 = $model->findOne($id1);
        $category2 = $model->findOne($id2);
        $tmp_order = $category1->order;
        $category1->order = $category2->order;
        $category1->save();
        $category2->order = $tmp_order;
        $category2->save();
    }

    /**
     * Deletes an existing Categories model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteAll()
    {
       // $this->findModel($id)->delete();
        $arIds = Yii::$app->request->post('ids');
        if(count($arIds)>0)
            Categories::deleteAll(['id'=>$arIds]);
        return $this->redirect(['gridview']);
    }

    /**
     * Finds the Categories model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Categories the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Categories::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
