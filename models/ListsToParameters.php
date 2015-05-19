<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lists_to_parameters".
 *
 * @property integer $id
 * @property integer $parameter_id
 * @property string $code
 * @property string $value
 * @property integer $order
 */
class ListsToParameters extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lists_to_parameters';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parameter_id', 'order'], 'integer'],
            [['code', 'value'], 'string', 'max' => 255],
            [['code', 'value'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parameter_id' => Yii::t('app', 'Parameter ID'),
            'code' => Yii::t('app', 'Code'),
            'value' => Yii::t('app', 'Value'),
            'order' => Yii::t('app', 'Order'),
        ];
    }
   
}
