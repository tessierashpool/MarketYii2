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
            [['name','status'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['parameters','variants','clearImages'], 'safe'],
            [['name'], 'required'],
            [['images'], 'file', 'extensions'=>'jpg, gif, png'],
            [['active'], 'boolean'],            
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
        {
            $arSearchParams = IParametersSearch::find()->where(['item_id'=>$this->id,'type'=>'p'])->asArray()->all();
            $arSimpleParams = IParametersSimple::find()->where(['item_id'=>$this->id,'type'=>'p'])->asArray()->all();
            $arMixed = array_merge($arSearchParams, $arSimpleParams);
            return $this->_parameters = ArrayHelper::map($arMixed,'parameter_id','value');
        }
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
            $arSearchParams = IParametersSearch::find()->where(['item_id'=>$this->id,'type'=>'v'])->asArray()->all();
            $arSimpleParams = IParametersSimple::find()->where(['item_id'=>$this->id,'type'=>'v'])->asArray()->all();
            $arMixed = array_merge($arSearchParams, $arSimpleParams);
            $arVariants = [];
            foreach($arMixed as $variant)
            {
                $arVariants[$variant['parameter_id']][$variant['value']]=$variant;
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
        if($this->save())
        {
            $this->saveParameters();
            $this->saveVariants();
            $this->saveImages();
            return true;
        }
        return false;
    }

    /**
     * Save parameters
     */
    public function saveParameters()
    {
        $use_in_search_params = ArrayHelper::map($parametersInfo = Categories::findOne(Yii::$app->request->get('category_id'))->fullParameters,'id','use_in_search');
        $arParams = $this->parameters;     
        $arSearchParamsQuery = [];
        $arSimpleParamsQuery = [];
        $arDeleteValues = [];
        if(count($arParams)>0)
        {
            foreach($arParams as $key=>$value)
            {
                if($use_in_search_params[$key])
                {
                    if($value!='')
                    {
                        $arSearchParamsQuery[] = [$this->id, $key, $value,'p'];
                    }                                      
                }
                else
                {
                    if($value!='')
                    {
                        $arSimpleParamsQuery[] = [$this->id, $key, $value,'p'];
                    }                     
                }
                $arDeleteValues[] = $key;
            }
        }

        IParametersSearch::deleteAll(['item_id'=>$this->id,'parameter_id'=>$arDeleteValues,'type'=>'p']);
        IParametersSimple::deleteAll(['item_id'=>$this->id,'parameter_id'=>$arDeleteValues,'type'=>'p']);
        if(count($arSearchParamsQuery)>0)
        {    
            Yii::$app->db->createCommand()->batchInsert(IParametersSearch::tableName(), ['item_id','parameter_id','value','type'], $arSearchParamsQuery)->execute();
        }
        if(count($arSimpleParamsQuery)>0)
        {    
            Yii::$app->db->createCommand()->batchInsert(IParametersSimple::tableName(), ['item_id','parameter_id','value','type'], $arSimpleParamsQuery)->execute();
        }        
    }

    /**
     * Save variants
     */
    public function saveVariants()
    {
        $use_in_search_variants = ArrayHelper::map($parametersInfo = Categories::findOne(Yii::$app->request->get('category_id'))->fullVariants,'id','use_in_search');
        $arVariants = $this->variants;
        $arSearchVariantsQuery = [];
        $arSimpleVariantsQuery = [];        
        if(count($arVariants)>0)
        {
            foreach($arVariants as $parent_id=>$arVariant)
            {
                foreach($arVariant as $key=>$variant)
                {
                    if($use_in_search_variants[$parent_id])
                    {
                        $arSearchVariantsQuery[] = [$this->id, $parent_id, $variant['value'], $variant['quantity'],'v']; 
                    }
                    else
                    {
                        $arSimpleVariantsQuery[] = [$this->id, $parent_id, $variant['value'], $variant['quantity'],'v']; 
                    }
                }
            }
        }
        IParametersSearch::deleteAll(['item_id'=>$this->id,'type'=>'v']);
        IParametersSimple::deleteAll(['item_id'=>$this->id,'type'=>'v']);
        if(count($arSearchVariantsQuery)>0)
        {    
            Yii::$app->db->createCommand()->batchInsert(IParametersSearch::tableName(), ['item_id','parameter_id','value','quantity','type'], $arSearchVariantsQuery)->execute();
        }
        if(count($arSimpleVariantsQuery)>0)
        {    
            Yii::$app->db->createCommand()->batchInsert(IParametersSimple::tableName(), ['item_id','parameter_id','value','quantity','type'], $arSimpleVariantsQuery)->execute();
        }        
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
        IParametersSimple::deleteAll('item_id = '.$this->id);
        IParametersSearch::deleteAll('item_id = '.$this->id);
        Whishlist::deleteAll('item_id = '.$this->id);
        Cart::deleteAll('item_id = '.$this->id);
        $this->removeImages();
        $this->delete();
    }

    public function parametersValidate()
    {
        //var_dump($this->parameters);
        //ItemsParametersValue
        //Yii::$app->db->createCommand()->batchInsert(ParametersToCategories::tableName(), ['id_category','id_parameter','order'], $arParamsQuery)->execute();
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

    public function getInfo()
    {
        $info = $this->getFullInfo();
        $arParameters = [];
        $arVariants = [];
        foreach ($info['category_parameters'] as $key => $value) {
            if(isset($info['parameters'][$value['id']]))
            {
                $arParameters[$value['code']]['id'] = $value['id'];
                $arParameters[$value['code']]['code'] = $value['code'];
                $arParameters[$value['code']]['name'] = $value['name'];
                if($value['type']=='list')
                {
                    foreach ($value['listValues'] as $listValue) {
                        if($listValue['code']==$info['parameters'][$value['id']])
                        {
                            $arParameters[$value['code']]['value'] = $listValue['value']; 
                            break;
                        }
                    }
                }
                else
                    $arParameters[$value['code']]['value'] = $info['parameters'][$value['id']];               
            }
        }
        foreach ($info['category_variants'] as $key => $value) {
            if(isset($info['variants'][$value['id']]))
            {
                
                $arVariants[$value['code']]['id'] = $value['id'];
                $arVariants[$value['code']]['code'] = $value['code'];
                $arVariants[$value['code']]['name'] = $value['name'];
                $tmpList = ArrayHelper::map($value['listValues'],'code','value');
                foreach ($info['variants'][$value['id']] as  $variant) {
                    $arVariants[$value['code']]['listValues'][$variant['value']]['code'] = $variant['value'];
                    $arVariants[$value['code']]['listValues'][$variant['value']]['quantity'] = $variant['quantity'];
                    $arVariants[$value['code']]['listValues'][$variant['value']]['value'] = $tmpList[$variant['value']];
                }            
            }
        }    
        return ['parameters'=>$arParameters,'variants'=>$arVariants];
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
            'active' => Yii::t('app', 'Active'),
        ];
    }


/*    public function getParametersValues()
    {
        return $this->hasMany(ItemsParametersValue::className(), ['item_id' => 'id']);
    }  */  
}
