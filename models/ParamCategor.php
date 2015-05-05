<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "param_categor".
 *
 * @property integer $id
 * @property string $name
 *
 * @property ParamNames[] $paramNames
 */
class ParamCategor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'param_categor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParamNames()
    {
        return $this->hasMany(ParamNames::className(), ['category_id' => 'id']);
    }
}
