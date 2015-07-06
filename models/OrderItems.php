<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_items".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $item_id
 * @property string $item_name
 * @property string $item_size
 * @property string $item_quantity
 * @property string $item_price
 */
class OrderItems extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'item_id' ,'item_price','item_quantity'], 'integer'],
            [['item_name', 'item_size'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'order_id' => Yii::t('app', 'Order ID'),
            'item_id' => Yii::t('app', 'Item ID'),
            'item_name' => Yii::t('app', 'Item Name'),
            'item_size' => Yii::t('app', 'Item Size'),
            'item_quantity' => Yii::t('app', 'Item Quantity'),
            'item_price' => Yii::t('app', 'Item Price'),
        ];
    }
}
