<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "param_names".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property integer $category_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property ParamCategor $category
 */
class ParamNames extends ActiveRecord
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
        return 'param_names';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['code', 'name'], 'string', 'max' => 255],
            [['code'], 'unique'],
            [['code','name','type'], 'required']
        ];
    }

    /**
     * @return boolen
     */
    public function saveParameter()
    {
        if($this->save())
        {
            if($this->type == 'list')
            {
                $arListValues = Yii::$app->request->post('list-value');
                $arListCodes = Yii::$app->request->post('list-code');
                $arParamsQuery = [];
                if(count($arListValues)>0)
                {
                    foreach($arListValues as $key=>$paramValue)
                    {
                        $arParamsQuery[] = [$this->id, $arListCodes[$key], $paramValue, $key+1];
                    }
                }
                ListsToParameters::deleteAll('parameter_id = '.$this->id);
                if(count($arParamsQuery)>0)
                {    
                    Yii::$app->db->createCommand()->batchInsert(ListsToParameters::tableName(), ['parameter_id','code','value','order'], $arParamsQuery)->execute();
                }
            }
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
            'name' => Yii::t('app', 'Name'),
            'category_id' => Yii::t('app', 'Category ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    public function getCategoriesList()
    {
        $def_array = ArrayHelper::map(ParamCategor::find()->asArray()->all(),'id','name');
       // array_unshift($def_array,"");
        return array_merge([0=>Yii::t('app', 'Custom')],$def_array);
    }

    public function getListValues()
    {
        $def_array = ArrayHelper::map(ParamCategor::find()->asArray()->all(),'id','name');
       // array_unshift($def_array,"");
        return array_merge([0=>Yii::t('app', 'Custom')],$def_array);
    }    

    public function getAllParameters()
    {
        $arCatList = $this->categoriesList;
        $arParams = $this->find()->select(['id','code','name','category_id','type'])->asArray()->all();
        $arCategiesAndParameters;
        foreach($arParams as $param)
        {
            if (isset($arCatList[$param['category_id']])) {
                $arCategiesAndParameters[$param['category_id']]['params'][] = $param;
                $arCategiesAndParameters[$param['category_id']]['name'] = $arCatList[$param['category_id']];
            }
            else
            {
                $arCategiesAndParameters[0]['params'][] = $param;
                $arCategiesAndParameters[0]['name'] = $arCatList[0];                
            }
        }
       // var_dump($arCategiesAndParameters);
        return $arCategiesAndParameters;
    }   

    public function getAllVariants()
    {
        $arCatList = $this->categoriesList;
        $arParams = $this->find()->select(['id','code','name','category_id'])->where(['type'=>'list'])->asArray()->all();
        $arCategiesAndParameters;
        foreach($arParams as $param)
        {
            if (isset($arCatList[$param['category_id']])) {
                $arCategiesAndParameters[$param['category_id']]['params'][] = $param;
                $arCategiesAndParameters[$param['category_id']]['name'] = $arCatList[$param['category_id']];
            }
            else
            {
                $arCategiesAndParameters[0]['params'][] = $param;
                $arCategiesAndParameters[0]['name'] = $arCatList[0];                
            }
        }
       // var_dump($arCategiesAndParameters);
        return $arCategiesAndParameters;
    }      

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ParamCategor::className(), ['id' => 'category_id']);
    }

    public function getValuesList()
    {
        return $this->hasMany(ListsToParameters::className(), ['parameter_id' => 'id']);
    }       
}
