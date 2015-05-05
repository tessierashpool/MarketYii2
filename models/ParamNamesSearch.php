<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ParamNames;

/**
 * ParamNamesSearch represents the model behind the search form about `app\models\ParamNames`.
 */
class ParamNamesSearch extends ParamNames
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['code', 'name'], 'safe'],
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
    public function search($params)
    {
        $query = ParamNames::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['>=', 'created_at', $params['created_at_from']])
            ->andFilterWhere(['<=', 'created_at', $params['created_at_to']])
            ->andFilterWhere(['>=', 'updated_at', $params['updated_at_from']])
            ->andFilterWhere(['<=', 'updated_at', $params['updated_at_to']])        
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
