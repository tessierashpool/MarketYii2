<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "i_parameters_search".
 *
 * @property integer $id
 * @property integer $item_id
 * @property integer $parameter_id
 * @property string $value
 * @property integer $quantity
 * @property string $type
 */
class IParametersSearch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'i_parameters_search';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'parameter_id', 'quantity'], 'integer'],
            [['type'], 'required'],
            [['value'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_id' => 'Item ID',
            'parameter_id' => 'Parameter ID',
            'value' => 'Value',
            'quantity' => 'Quantity',
            'type' => 'Type',
        ];
    }
}
