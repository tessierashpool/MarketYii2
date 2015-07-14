<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Order;

/**
 * OrderSearch represents the model behind the search form about `app\models\Order`.
 */
class OrderSearch extends Order
{
    public $fullname;
    public $s_address;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'delivery_id', 'delivery_price', 'payment_id', 'total_price', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['s_address','fullname','first_name', 'last_name', 'state', 'city', 'adress', 'telephone', 'email', 'status'], 'safe'],
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
        $query = Order::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC]]
        ]);

        $this->load($params);

        $dataProvider->sort->attributes['fullname'] = [
            'asc' => ['first_name' => SORT_ASC, 'last_name' => SORT_ASC],
            'desc' => ['first_name' => SORT_DESC, 'last_name' => SORT_DESC]
        ];

        $dataProvider->sort->attributes['s_address'] = [
            'asc' => ['state' => SORT_ASC, 'city' => SORT_ASC, 'adress' => SORT_ASC],
            'desc' => ['state' => SORT_DESC, 'city' => SORT_DESC, 'adress' => SORT_DESC]
        ];

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'delivery_id' => $this->delivery_id,
            'delivery_price' => $this->delivery_price,
            'payment_id' => $this->payment_id,
            'total_price' => $this->total_price,
            //'created_at' => $this->created_at,
            //'updated_at' => $this->updated_at,
            //'created_by' => $this->created_by,
            //'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'adress', $this->adress])
            ->andFilterWhere(['like', 'telephone', $this->telephone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['>=', 'created_at', $params['created_at_from']])
            ->andFilterWhere(['<=', 'created_at', $params['created_at_to']])
            ->andFilterWhere(['>=', 'updated_at', $params['updated_at_from']])
            ->andFilterWhere(['<=', 'updated_at', $params['updated_at_to']])             
            ->andFilterWhere(['like', 'status', $this->status]);

        $query->andFilterWhere(['or',['like', 'first_name', $this->fullname],['like', 'last_name', $this->fullname]])
            ->andFilterWhere(['or',['like', 'state', $this->s_address],['like', 'city', $this->s_address],['like', 'adress', $this->s_address]]);

        return $dataProvider;
    }
}
