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
    public function search($params,$active = '',$onPage=20)
    {
        $query = Items::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $onPage,
            ],  
            //'totalCount'=>'2000'          
        ]);

        $this->load($params);
        //Filter by selected category
        if(Yii::$app->request->get('category_id')>0)
            $arCategories = Categories::getAllChilds(Yii::$app->request->get('category_id'));
        else
            $arCategories = [];

        //Prepare price filter
        if($params['filter']['price']!='')
        {
            $arPrice = explode(':',$params['filter']['price']);
        }
        unset($params['filter']['price']);

        //Prepare filters other parameters
        if(count($params['filter'])>0)
        {           
            foreach ($params['filter'] as $key => $value) {
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
        $query->distinct(true)->orderBy(['items.id'=>SORT_ASC]);
        return $dataProvider;
    }

}
