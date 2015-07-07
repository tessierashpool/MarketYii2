<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $state
 * @property string $city
 * @property string $adress
 * @property string $telephone
 * @property string $email
 * @property integer $delivery_id
 * @property integer $delivery_price
 * @property integer $payment_id
 * @property integer $total_price
 * @property string $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $updated_by
 */
class Order extends ActiveRecord
{
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ]
            ],
            'blameable' => [
                'class' => 'yii\behaviors\BlameableBehavior',
                'updatedByAttribute' => 'updated_by',
                ],                          
        ];
     } 

    private $orderItems = [];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'delivery_id', 'payment_id', 'total_price', 'created_at', 'updated_at', 'delivery_price', 'updated_by'], 'integer'],
            [['first_name', 'last_name', 'state', 'city', 'adress', 'telephone', 'email',  'status'], 'string', 'max' => 255],
            [['first_name', 'last_name', 'state', 'city', 'adress', 'telephone'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'state' => Yii::t('app', 'State'),
            'city' => Yii::t('app', 'City'),
            'adress' => Yii::t('app', 'Adress'),
            'telephone' => Yii::t('app', 'Telephone'),
            'email' => Yii::t('app', 'Email'),
            'delivery_id' => Yii::t('app', 'Delivery ID'),
            'delivery_price' => Yii::t('app', 'Delivery Price'),
            'payment_id' => Yii::t('app', 'Payment ID'),
            'total_price' => Yii::t('app', 'Total Price'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    public function saveOrder()
    {
        if(!Yii::$app->user->isGuest)
            $this->user_id=Yii::$app->user->id;
        if($this->prepeareOrderItems()&&$this->save())
        {
            $this->saveOrderItems($this->id);
            return true;
        }
        return false;
    } 

    public function prepeareOrderItems()
    {
        $cart = Cart::getCart();
        $orderItem = [];
        $totalPrice = 0;
        foreach ($cart as $key => $cartItem) {
            $item = Items::findOne($cartItem['id']); 
            $orderItem['item_id'] = $item->id;  
            $orderItem['item_name'] = $item->name;  
            $orderItem['item_size'] = $cartItem['sname'];  
            $orderItem['item_quantity'] = $cartItem['quantity'];  
            $orderItem['item_price'] = $item->price;  
            $this->orderItems[] = $orderItem;
            $totalPrice += $orderItem['item_price']*$cartItem['quantity'];
        }
        $this->total_price = $totalPrice;
        $this->delivery_id = 1;
        $this->delivery_price = 0;
        $this->status = 'processed';
        return true;
    }  

    public function saveOrderItems($order_id)
    {
        foreach ($this->orderItems as $key => $orderItem) {
            $item = new OrderItems();
            $item->item_id = $orderItem['item_id'];  
            $item->order_id = $order_id;  
            $item->item_name = $orderItem['item_name'];  
            $item->item_size = $orderItem['item_size'];  
            $item->item_quantity = $orderItem['item_quantity'];  
            $item->item_price = $orderItem['item_price'];    
            $item->save();
        }
    } 

    public function getItems()
    {
        return $this->hasMany(OrderItems::className(), ['order_id' => 'id']);
    } 

    public static function getMyOrdersDataProvider()
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 30,
            ]            
        ]);

        $query->select('id, status, created_at');
        $query->orFilterWhere([
            'user_id' => Yii::$app->user->id,
        ]);

        return $dataProvider;
    } 

}
