<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "categories".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property integer $parent_id
 * @property integer $depth
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class Categories extends ActiveRecord
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
        return 'categories';
    }    

    /**
     * @return boolen
     */
    public function saveCategory()
    {
        if($this->save())
        {

            $arParams = Yii::$app->request->post('params');
            $arParamsQuery = [];
            if(count($arParams)>0)
            {
                foreach($arParams as $key=>$paramId)
                {
                    $arParamsQuery[] = [$this->id, $paramId, $key+1];
                }
            }
            ParametersToCategories::deleteAll('id_category = '.$this->id);
            if(count($arParamsQuery)>0)
            {    
                Yii::$app->db->createCommand()->batchInsert(ParametersToCategories::tableName(), ['id_category','id_parameter','order'], $arParamsQuery)->execute();
            }
            return true;
        }
        return false;
    }

    public function getCatParameters()
    {
        $model = new ParametersToCategories();  
        return $model->find()->with('parametersInfo')->where(['id_category'=>$this->id])->orderBy('order ASC')->asArray()->all();
    }

    public function getParentParameters()
    {
        $model = new ParametersToCategories();  
        return $model->find()->with('parametersInfo')->where(['id_category'=>$this->parent_id])->orderBy('order ASC')->asArray()->all();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'depth', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['order'], 'integer','on'=>'create'],
            [['code', 'name', 'description'], 'string', 'max' => 255],
            [['code', 'name'], 'required'],
            [['code'], 'unique']
        ];
    }

    public function getTree()
    {
        return $this->find()->select(['id','name','depth','parent_id'])->asArray()->orderBy('order ASC')->all();
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
            'description' => Yii::t('app', 'Description'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'depth' => Yii::t('app', 'Depth'),
            'order' => Yii::t('app', 'Order'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }
   
}
