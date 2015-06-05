<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Items;
use yii\helpers\ArrayHelper;

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
    public function search($params,$onPage=20)
    {
        $query = Items::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $onPage,
            ],            
        ]);

        $this->load($params);
        //Filter by selected category
        if(Yii::$app->request->get('category_id')>0)
            $arCategories = self::categoriesSearch(Yii::$app->request->get('category_id'));
        else
            $arCategories = [];

        if($params['filter']['price']!='')
        {
            $arPrice = explode(':',$params['filter']['price']);
        }
        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
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

        return $dataProvider;
    }

    public static function categoriesSearch($id)
    {
        $arQuery = Yii::$app->db->createCommand('SELECT id, parent_id, depth FROM '.Categories::tableName())
                     ->queryAll();
        $arQuery = ArrayHelper::map($arQuery,'id','depth','parent_id');             
        $result = self::categoriesArray($arQuery,$id);
        return $result;
    }

    public static  function categoriesArray($arQuery,$id)
    {
        $arCategories[] = $id;
        if(count($arQuery[$id])>0)
            foreach ($arQuery[$id] as $key => $value) {
                unset($arQuery[$id]);
                $arCategories = array_merge( $arCategories,  self::categoriesArray($arQuery, $key));
            }
        return $arCategories;
    }
}
