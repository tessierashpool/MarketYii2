<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\helpers\Html;

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
    private $_variants;
    public $images;
    public $clearImages;
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
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]                
             
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
            [['price', 'created_at', 'updated_at', 'created_by', 'updated_by','category_id','quantity'], 'integer'],
            [['name', 'description','status'], 'string', 'max' => 255],
            [['parameters','variants','clearImages'], 'safe'],
            [['name'], 'required'],
            [['images'], 'file', 'extensions'=>'jpg, gif, png'],
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

    public function getStatusList()
    {        
        $arStatus[] = '';
        $arStatus['new'] = Yii::t('app', 'New');
        $arStatus['top'] = Yii::t('app', 'Top');
        $arStatus['sale'] = Yii::t('app', 'Sale');
        return $arStatus;
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

    /**
     * Variants property getter
     * @inheritdoc
     */
    public function getVariants()
    {        
        if(count($this->_variants)>0)
            return  $this->_variants;
        elseif($this->id!=null)
        {
            $arVariantsTmp = ItemsVariants::find()->where(['id_item'=>$this->id])->asArray()->all();
            $arVariants = [];
            foreach($arVariantsTmp as $variant)
            {
                $arVariants[$variant['parent_id']][$variant['code']]=$variant;
            }
            return $arVariants;
        }            
        else 
            return [];
    }

    /**
     * Variants property setter
     */
    public function setVariants($value)
    {
        $this->_variants = $value;
    }      

    public function saveItem()
    {
        $arParams = $this->parameters;
        $arVariants = $this->variants;
/*        $image = UploadedFile::getInstance($this, $this->images[1]);
        var_dump($image);*/
        if($this->save())
        {
            $arParamsQuery = [];
            if(count($arParams)>0)
            {
                foreach($arParams as $key=>$value)
                {
                    if($value!='')
                        $arParamsQuery[] = [$this->id, $key, $value];
                }
            }
            ItemsParametersValue::deleteAll('item_id = '.$this->id);
            if(count($arParamsQuery)>0)
            {    
                Yii::$app->db->createCommand()->batchInsert(ItemsParametersValue::tableName(), ['item_id','parameter_id','value'], $arParamsQuery)->execute();
            }

            $arVariantsQuery = [];
            if(count($arVariants)>0)
            {
                foreach($arVariants as $parent_id=>$arVariant)
                {
                    foreach($arVariant as $key=>$variant)
                    {
                         $arVariantsQuery[] = [$this->id, $parent_id, $variant['code'], $variant['quantity']]; 
                    }
                }
            }
            ItemsVariants::deleteAll('id_item = '.$this->id);
            if(count($arVariantsQuery)>0)
            {    
                Yii::$app->db->createCommand()->batchInsert(ItemsVariants::tableName(), ['id_item','parent_id','code','quantity'], $arVariantsQuery)->execute();
            }
            $this->saveImages();
            return true;
        }
        return false;
    }

    /**
     * Save and Attach images to model
     */
    public function saveImages()
    {
        $images = UploadedFile::getInstances($this, 'images');
        if(count($images)>0||$this->clearImages)
            $this->removeImages();
        foreach($images as $image)
        {            
            $image->saveAs(Yii::getAlias('@webroot/uploads/').$image->name);
            $this->attachImage(Yii::getAlias('@webroot/uploads/').$image->name);
            unlink(Yii::getAlias('@webroot/uploads/').$image->name);
        }
    }

    /**
     * Get initialPreview images for kartik FileInput widget
     * @return array
     */
    public function getInitialPreview()
    {
        $images = $this->getImages();
        $arImages = [];
        foreach($images as $image)
        {
            if($image->urlAlias !='placeHolder')
                $arImages[] = Html::img($image->getUrl('150x'), ['class'=>'file-preview-image']);
        }            
        return $arImages;
    }

    /**
     * Delete item
     */
    public function deleteItem()
    {        
        ItemsParametersValue::deleteAll('item_id = '.$this->id);
        ItemsVariants::deleteAll('id_item = '.$this->id);
        $this->removeImages();
        $this->delete();
    }

    public function parametersValidate()
    {
        //var_dump($this->parameters);
        //ItemsParametersValue
       // Yii::$app->db->createCommand()->batchInsert(ParametersToCategories::tableName(), ['id_category','id_parameter','order'], $arParamsQuery)->execute();
        //$this->addError('parameters5',Yii::t('yii', '{attribute} cannot be blank.', ['attribute' => 'Categories']));
        return false;
    }

    public function getFullInfo()
    {
        $category_model = Categories::findOne($this->category_id);
        $arInfo['category_parameters'] = $category_model->fullParameters;
        $arInfo['category_variants'] = $category_model->fullVariants;
        $arInfo['parameters'] = $this->parameters;
        $arInfo['variants'] = $this->variants;
        return $arInfo;
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
