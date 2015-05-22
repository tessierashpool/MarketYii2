<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "items".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $price
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class Items extends ActiveRecord
{
    private $_parameters;
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
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
                ],
             
        ];
     }    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price', 'created_at', 'updated_at', 'created_by', 'updated_by','category_id'], 'integer'],
            [['name', 'description'], 'string', 'max' => 255],
            [['parameters'], 'safe'],
            [['name'], 'required'],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            return true;
        } else {
            return false;
        }
    }

    public function getParameters()
    {        
        if(count($this->_parameters)>0)
            return  $this->_parameters;
        elseif($this->id!=null)
            return $this->_parameters = ArrayHelper::map(ItemsParametersValue::find()->where(['item_id'=>$this->id])->asArray()->all(),'parameter_id','value');
        else 
            return [];
    }

    public function setParameters($value)
    {
        $this->_parameters = $value;
    }    

    public function saveItem()
    {
        $arParams = $this->parameters;
        if($this->save())
        {
            $arParamsQuery = [];
            if(count($arParams)>0)
            {
                foreach($arParams as $key=>$value)
                {
                    $arParamsQuery[] = [$this->id, $key, $value];
                }
            }
            ItemsParametersValue::deleteAll('item_id = '.$this->id);
            if(count($arParamsQuery)>0)
            {    
                Yii::$app->db->createCommand()->batchInsert(ItemsParametersValue::tableName(), ['item_id','parameter_id','value'], $arParamsQuery)->execute();
            }
            return true;
        }
        return false;
    }

    public function parametersValidate()
    {
        //var_dump($this->parameters);
        //ItemsParametersValue
       // Yii::$app->db->createCommand()->batchInsert(ParametersToCategories::tableName(), ['id_category','id_parameter','order'], $arParamsQuery)->execute();
        //$this->addError('parameters5',Yii::t('yii', '{attribute} cannot be blank.', ['attribute' => 'Categories']));
        return false;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'price' => Yii::t('app', 'Price'),
            'category_id' => Yii::t('app', 'Category'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }
}
