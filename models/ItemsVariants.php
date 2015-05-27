<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "items_variants".
 *
 * @property integer $id
 * @property integer $id_item
 * @property integer $id_variant_parent
 * @property string $code
 * @property integer $quantity
 */
class ItemsVariants extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'items_variants';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_item', 'parent_id', 'quantity'], 'integer'],
            [['code'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_item' => Yii::t('app', 'Id Item'),
            'parent_id' => Yii::t('app', 'Id Variant Parent'),
            'code' => Yii::t('app', 'Code'),
            'quantity' => Yii::t('app', 'Quantity'),
        ];
    }
}
