<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parameters_to_categories".
 *
 * @property integer $id
 * @property integer $id_category
 * @property integer $id_parameter
 * @property integer $order
 */
class ParametersToCategories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parameters_to_categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_category', 'id_parameter', 'order'], 'integer']
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
            'id_parameter' => Yii::t('app', 'Id Parameter'),
            'order' => Yii::t('app', 'Order'),
        ];
    }

    public function getParametersInfo()
    {
        return $this->hasOne(ParamNames::className(), ['id' => 'id_parameter']);
    }     
}
