<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "items_parameters_value".
 *
 * @property integer $id
 * @property integer $item_id
 * @property integer $parameter_id
 * @property string $value
 */
class ItemsParametersValue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'items_parameters_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'parameter_id'], 'integer'],
            [['value'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'item_id' => Yii::t('app', 'Item ID'),
            'parameter_id' => Yii::t('app', 'Parameter ID'),
            'value' => Yii::t('app', 'Parameter Value'),
        ];
    }
}
