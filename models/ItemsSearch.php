<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Items;
use yii\helpers\ArrayHelper;
use yii\db\Query;

/**
 * ItemsSearch represents the model behind the search form about `app\models\Items`.
 */
class ItemsSearch extends Items
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'price', 'created_at', 'updated_at', 'created_by', 'updated_by','category_id'], 'integer'],
            [['name', 'description'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params,$active = '',$onPage=20,$orderByDate = false)
    {
        $query = Items::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $onPage,
            ],  
            //'totalCount'=>'2000'          
        ]);
        
        $dataProvider->sort->defaultOrder = [
            'created_at' => SORT_DESC
        ];

        $this->load($params);
        $session = Yii::$app->session;
        $filter =[];
/*        if($session->has('filter'))
            $filter = $session->get('filter');*/
        if(isset($params['filter'])&&count($params['filter'])>0)   
            $filter = $params['filter'];

        //Filter by selected category
        if(Yii::$app->request->get('category_id')>0)
            $arCategories = Categories::getAllChilds(Yii::$app->request->get('category_id'));
        elseif (Yii::$app->request->get('c')!='') {
            $arCategories = Categories::getAllChildsByCode(Yii::$app->request->get('c'));
        }
        else
            $arCategories = [];

        //Prepare price filter
        if(isset($filter['price'])&&$filter['price']!='')
        {
            $arPrice = explode(':',$filter['price']);
        }
        unset($filter['price']);

        //Prepare filters other parameters
        if(count($filter)>0)
        {           
            foreach ($filter as $key => $value) {
                $query->innerJoin('i_parameters_search a'.$key,'items.id = a'.$key.'.item_id');
                $query->andFilterWhere(['a'.$key.'.parameter_id'=>$key,'a'.$key.'.value'=>$value]);
            }
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'active' => $active,
            'id' => $this->id,
           // 'price' => $this->price,
            //'category_id' => $this->category_id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['in', 'category_id', $arCategories])
            ->andFilterWhere(['>=', 'price', $arPrice[0]])
            ->andFilterWhere(['<=', 'price', $arPrice[1]])
            ->andFilterWhere(['>=', 'created_at', $params['created_at_from']])
            ->andFilterWhere(['<=', 'created_at', $params['created_at_to']])
            ->andFilterWhere(['>=', 'updated_at', $params['updated_at_from']])
            ->andFilterWhere(['<=', 'updated_at', $params['updated_at_to']])        
            ->andFilterWhere(['like', 'description', $this->description]);
        $query->distinct(true)->orderBy(['items.created_at'=>SORT_DESC]);
        return $dataProvider;
    }

}
