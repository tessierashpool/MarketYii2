<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "variants_to_categories".
 *
 * @property integer $id
 * @property integer $id_category
 * @property integer $id_variant
 * @property integer $order
 */
class VariantsToCategories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'variants_to_categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_category', 'id_variant', 'order'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_category' => Yii::t('app', 'Id Category'),
            'id_variant' => Yii::t('app', 'Id Variant'),
            'order' => Yii::t('app', 'Order'),
        ];
    }

    public function getVariantsInfo()
    {
        return $this->hasOne(ParamNames::className(), ['id' => 'id_variant']);
    }     
}
