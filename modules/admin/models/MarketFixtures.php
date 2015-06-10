<?php

namespace app\modules\admin\models;

use yii\base\Model;
use app\models\ParamNames;
use app\models\ListsToParameters;
use app\models\Categories;
use app\models\VariantsToCategories;
use app\models\ParametersToCategories;
use app\models\Items;
use app\models\ItemsVariants;
use app\models\ItemsParametersValue;
use app\models\IParametersSimple;
use app\models\IParametersSearch;
use yii\helpers\ArrayHelper;
use Yii;

class MarketFixtures extends Model
{
    
    public function getCategories(){
        $arCategories[] = [
            'name'=>'For Men',
            'code'=>'men',
            'description'=>'Clothing for Men',
            'parent_id'=>'',
            'have_variants'=>'1',
            'order'=>'1',
            'variants'=>['size'],
            'parameters'=>['brand','material-top','inner-material','footer-material','season','quaility','color']
        ];
            $arCategories[] = [
                'name'=>'Jeans',
                'code'=>'men-jeans',
                'parent_id'=>'1',
                'order'=>'2',
                'depth'=>'1',
                'description'=>'Jeans for men',
                'have_variants'=>'1',
                'variants'=>['size'],
                'parameters'=>['brand','material-top','inner-material','footer-material','season','quaility','color']
            ];  
                $arCategories[] = [
                    'name'=>'Wide Jeans',
                    'code'=>'men-wide-jeans',
                    'parent_id'=>'2',
                    'order'=>'3',
                    'depth'=>'2',
                    'description'=>'Wide Jeans for men',
                    'have_variants'=>'1',
                    'variants'=>['size'],
                    'parameters'=>['brand','material-top','inner-material','footer-material','season','quaility','color']
                ];  
                $arCategories[] = [
                    'name'=>'Skinny Jeans',
                    'code'=>'men-skinny-jeans',
                    'parent_id'=>'2',
                    'order'=>'4',
                    'depth'=>'2',
                    'description'=>'Skinny Jeans for men',
                    'have_variants'=>'1',
                    'variants'=>['size'],
                    'parameters'=>['brand','material-top','inner-material','footer-material','season','quaility','color']
                ];  
                $arCategories[] = [
                    'name'=>'Classic Jeans',
                    'code'=>'men-classic-jeans',
                    'parent_id'=>'2',
                    'order'=>'5',
                    'depth'=>'2',
                    'description'=>'Classic Jeans for men',
                    'have_variants'=>'1',
                    'variants'=>['size'],
                    'parameters'=>['brand','material-top','inner-material','footer-material','season','quaility','color']
                ];                                            
            $arCategories[] = [
                'name'=>'Outerwear',
                'code'=>'men-outwear',
                'parent_id'=>'1',
                'order'=>'6',
                'depth'=>'1',
                'description'=>'Outerwear for men',
                'have_variants'=>'1',
                'variants'=>['size'],
                'parameters'=>['brand','material-top','inner-material','footer-material','season','quaility','color']
            ];                   
        $arCategories[] = [
            'name'=>'For Women',
            'code'=>'women',
            'order'=>'7',
            'description'=>'Clothing for Women',
            'have_variants'=>'1',
            'variants'=>['size'],
            'parameters'=>['brand','material-top','inner-material','footer-material','season','quaility','color']
        ];
            $arCategories[] = [
                'name'=>'Jeans',
                'code'=>'women-jeans',
                'parent_id'=>'7',
                'order'=>'8',
                'depth'=>'1',
                'description'=>'Jeans for women',
                'have_variants'=>'1',
                'variants'=>['size'],
                'parameters'=>['brand','material-top','inner-material','footer-material','season','quaility','color']
            ];  
                $arCategories[] = [
                    'name'=>'Wide Jeans',
                    'code'=>'women-wide-jeans',
                    'parent_id'=>'8',
                    'order'=>'9',
                    'depth'=>'2',
                    'description'=>'Wide Jeans for women',
                    'have_variants'=>'1',
                    'variants'=>['size'],
                    'parameters'=>['brand','material-top','inner-material','footer-material','season','quaility','color']
                ];  
                $arCategories[] = [
                    'name'=>'Skinny Jeans',
                    'code'=>'women-skinny-jeans',
                    'parent_id'=>'8',
                    'order'=>'10',
                    'depth'=>'2',
                    'description'=>'Skinny Jeans for women',
                    'have_variants'=>'1',
                    'variants'=>['size'],
                    'parameters'=>['brand','material-top','inner-material','footer-material','season','quaility','color']
                ];  
                $arCategories[] = [
                    'name'=>'Classic Jeans',
                    'code'=>'women-classic-jeans',
                    'parent_id'=>'8',
                    'order'=>'11',
                    'depth'=>'2',
                    'description'=>'Classic Jeans for women',
                    'have_variants'=>'1',
                    'variants'=>['size'],
                    'parameters'=>['brand','material-top','inner-material','footer-material','season','quaility','color']
                ];                                            
            $arCategories[] = [
                'name'=>'Outerwear',
                'code'=>'women-top',
                'parent_id'=>'7',
                'order'=>'12',
                'depth'=>'1',
                'description'=>'Outerwear for women',
                'have_variants'=>'1',
                'variants'=>['size'],
                'parameters'=>['brand','material-top','inner-material','footer-material','season','quaility','color']
            ];          
        $arCategories[] = [
            'name'=>'For Children',
            'code'=>'children',
            'order'=>'13',
            'description'=>'Clothing for Children',
            'have_variants'=>'1',
            'variants'=>['size'],
            'parameters'=>['brand','material-top','inner-material','footer-material','season','quaility','color']
        ];   
            $arCategories[] = [
                'name'=>'Jeans',
                'code'=>'children-jeans',
                'parent_id'=>'13',
                'order'=>'14',
                'depth'=>'1',
                'description'=>'Jeans for children',
                'have_variants'=>'1',
                'variants'=>['size'],
                'parameters'=>['brand','material-top','inner-material','footer-material','season','quaility','color']
            ];  
                $arCategories[] = [
                    'name'=>'Wide Jeans',
                    'code'=>'children-wide-jeans',
                    'parent_id'=>'14',
                    'order'=>'15',
                    'depth'=>'2',
                    'description'=>'Wide Jeans for children',
                    'have_variants'=>'1',
                    'variants'=>['size'],
                    'parameters'=>['brand','material-top','inner-material','footer-material','season','quaility','color']
                ];  
                $arCategories[] = [
                    'name'=>'Skinny Jeans',
                    'code'=>'children-skinny-jeans',
                    'parent_id'=>'14',
                    'order'=>'16',
                    'depth'=>'2',
                    'description'=>'Skinny Jeans for children',
                    'have_variants'=>'1',
                    'variants'=>['size'],
                    'parameters'=>['brand','material-top','inner-material','footer-material','season','quaility','color']
                ];  
                $arCategories[] = [
                    'name'=>'Classic Jeans',
                    'code'=>'children-classic-jeans',
                    'parent_id'=>'14',
                    'order'=>'17',
                    'depth'=>'2',
                    'description'=>'Classic Jeans for children',
                    'have_variants'=>'1',
                    'variants'=>['size'],
                    'parameters'=>['brand','material-top','inner-material','footer-material','season','quaility','color']
                ];                                            
            $arCategories[] = [
                'name'=>'Outerwear',
                'code'=>'children-top',
                'parent_id'=>'13',
                'order'=>'18',
                'depth'=>'1',
                'description'=>'Outerwear for children',
                'have_variants'=>'1',
                'variants'=>['size'],
                'parameters'=>['brand','material-top','inner-material','footer-material','season','quaility','color']
            ];                        
        return $arCategories;
    }

    public function getParameters(){
        $arParameters[] = ['use_in_search'=>0,'code'=>'material-top','name'=>'Upper material','type'=>'text'];
        $arParameters[] = ['use_in_search'=>0,'code'=>'inner-material','name'=>'Inside material ','type'=>'text'];
        $arParameters[] = ['use_in_search'=>0,'code'=>'footer-material','name'=>'Insole material','type'=>'text'];
        $arParameters[] = ['use_in_search'=>0,'code'=>'season','name'=>'Season','type'=>'text'];
        $arParameters[] = ['use_in_search'=>0,'code'=>'quaility','name'=>'Quality','type'=>'text'];
        $arParameters[] = ['use_in_search'=>1,'code'=>'brand','name'=>'Brand','type'=>'text'];
        $arParameters[] = ['use_in_search'=>1,'code'=>'color','name'=>'Color','type'=>'list',
            'listValues'=>[
                ['code'=>'red','name'=>'Red'],
                ['code'=>'yellow','name'=>'Yellow'],
                ['code'=>'green','name'=>'Green'],
                ['code'=>'black','name'=>'Black'],
                ['code'=>'beige','name'=>'Beige'],
                ['code'=>'white','name'=>'White'],
                ['code'=>'multi','name'=>'Multi']
            ]
        ];
        $arParameters[] = ['use_in_search'=>1,'code'=>'size','name'=>'Size','type'=>'list',
            'listValues'=>[
                ['code'=>'xl','name'=>'XL'],
                ['code'=>'m','name'=>'M'],
                ['code'=>'l','name'=>'L'],
                ['code'=>'s','name'=>'S']
            ]
        ];          

        return $arParameters;
    }   

    public function getItems(){
        $arItems[] = [
            'name'=>'Simple Print T-Shirt',
            'description'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'price'=>1500,
            'quantity'=>10,
            'variants'=>[
                ['parent_code'=>'size','code'=>'xl','quantity'=>10],
                ['parent_code'=>'size','code'=>'m','quantity'=>2],
                ['parent_code'=>'size','code'=>'l','quantity'=>5]
            ],
            'parameters'=>[
                'brand'=>'AG Adriano Goldshmeid',
                'material-top'=>'artificial leather, synthetic nubuck',
                'inner-material'=>'faux fur',
                'footer-material'=>'leather',
                'season'=>'Demi-season, Winter',
                'quaility'=>'best',
                'color'=>'red',
            ],
            'images'=>[1,2,3]
        ];
        $arItems[] = [
            'name'=>'Simple Print T-Shirt',
            'description'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'price'=>1500,
            'quantity'=>10,
            'variants'=>[
                ['parent_code'=>'size','code'=>'m','quantity'=>4],
                ['parent_code'=>'size','code'=>'l','quantity'=>7]
            ],
            'parameters'=>[
                'brand'=>'Alice & Olivia',
                'material-top'=>'artificial leather, synthetic nubuck',
                'inner-material'=>'faux fur',
                'footer-material'=>'rubber',
                'season'=>'Demi-season, Winter',
                'quaility'=>'best',
                'color'=>'yellow',
            ],
            'images'=>[2,3,4]
        ]; 
        $arItems[] = [
            'name'=>'Simple Print T-Shirt',
            'description'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'price'=>1500,
            'quantity'=>10,
            'variants'=>[
                ['parent_code'=>'size','code'=>'s','quantity'=>10]
            ],
            'parameters'=>[
                'brand'=>'Autumn Cashmere',
                'material-top'=>'artificial leather, synthetic nubuck',
                'inner-material'=>'faux fur',
                'footer-material'=>'textile',
                'season'=>'Demi-season, Winter',
                'quaility'=>'best',
                'color'=>'green',
            ],
            'images'=>[3,4,5]
        ]; 
        $arItems[] = [
            'name'=>'Simple Print T-Shirt',
            'description'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'price'=>1500,
            'quantity'=>10,
            'variants'=>[
                ['parent_code'=>'size','code'=>'s','quantity'=>10]
            ],
            'parameters'=>[
                'brand'=>'BCBGMAXAZRIA',
                'material-top'=>'artificial leather, synthetic nubuck',
                'inner-material'=>'faux fur',
                'footer-material'=>'textile',
                'season'=>'Demi-season, Winter',
                'quaility'=>'best',
                'color'=>'black',
            ],
            'images'=>[4,5,6]
        ];                               
        $arItems[] = [
            'name'=>'Simple Print T-Shirt',
            'description'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'price'=>1500,
            'quantity'=>10,
            'variants'=>[
                ['parent_code'=>'size','code'=>'s','quantity'=>10]
            ],
            'parameters'=>[
                'brand'=>'DKNY',
                'material-top'=>'artificial leather, synthetic nubuck',
                'inner-material'=>'faux fur',
                'footer-material'=>'textile',
                'season'=>'Demi-season, Winter',
                'quaility'=>'best',
                'color'=>'multi',
            ],
            'images'=>[5,6,1]
        ]; 
        $arItems[] = [
            'name'=>'Simple Print T-Shirt',
            'description'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'price'=>1500,
            'quantity'=>10,
            'variants'=>[
                ['parent_code'=>'size','code'=>'s','quantity'=>10]
            ],
            'parameters'=>[
                'brand'=>'Magaschoni',
                'material-top'=>'artificial leather, synthetic nubuck',
                'inner-material'=>'faux fur',
                'footer-material'=>'textile',
                'season'=>'Demi-season, Winter',
                'quaility'=>'best',
                'color'=>'beige',
            ],
            'images'=>[6,1,2]
        ];         

        return $arItems;
    }

    public function addParamsToDB(){        
        $arParams = $this->parameters;
        foreach ($arParams as $key => $value) {
            $paramsModel = new ParamNames();
            $paramsModel->active = 1;
            $paramsModel->name = $value['name'];
            $paramsModel->code = $value['code'];
            $paramsModel->type = $value['type'];
            $paramsModel->use_in_search = $value['use_in_search'];            
            $paramsModel->category_id = 0;
            if($paramsModel->save()&&(count($value['listValues'])>0))
            {
                foreach ($value['listValues'] as $listKey => $listValue) {
                    $paramListModel = new ListsToParameters();
                    $paramListModel->parameter_id = $paramsModel->id;
                    $paramListModel->code = $listValue['code'];
                    $paramListModel->value = $listValue['name'];
                    $paramListModel->order = $listKey;
                    $paramListModel->save();
                }
            }
        }      
    }

    public function addCategoriesToDB(){        
        $arCategories = $this->categories;
        $arParams =  ArrayHelper::map(ParamNames::find()->select(['id','code'])->asArray()->all(),'code','id');
        foreach ($arCategories as $key => $value) {
            $catModel = new Categories();
            $catModel->active = 1;
            $catModel->name = $value['name'];
            $catModel->code = $value['code'];
            $catModel->parent_id = $value['parent_id'];
            $catModel->order = $value['order'];
            $catModel->depth = $value['depth'];
            $catModel->description = $value['description'];
            $catModel->have_variants = $value['have_variants'];
            if($catModel->save())
            {
                if(count($value['variants'])>0)
                {
                    foreach ($value['variants'] as $keyVariant => $valueVariant) {
                        $variantsModel = new VariantsToCategories();
                        $variantsModel->id_category = $catModel->id;
                        $variantsModel->id_variant = $arParams[$valueVariant];
                        $variantsModel->order = $keyVariant;
                        $variantsModel->save();
                    }                    
                    
                }
                if(count($value['parameters'])>0)
                {
                    foreach ($value['parameters'] as $keyParameter => $valueParameter) {
                        $paramsModel = new ParametersToCategories();
                        $paramsModel->id_category = $catModel->id;
                        $paramsModel->id_parameter = $arParams[$valueParameter];
                        $paramsModel->order = $keyParameter;
                        $paramsModel->save();
                    }                    
                    
                }                
            }
        }      
    }    

    public function addItemsToDB(){        
        $arItems = $this->items;
        $arCategories =  Categories::find()->where(['depth'=>2])->select(['id','code'])->asArray()->all();
        $arParamsTmp = ParamNames::find()->select(['id','code','use_in_search'])->asArray()->all();
        $arParams = [];
        foreach ($arParamsTmp as $key => $value) {
            $arParams[$value['code']]['id'] = $value['id'];
            $arParams[$value['code']]['code'] = $value['code'];
            $arParams[$value['code']]['use_in_search'] = $value['use_in_search'];
        }
        foreach ($arCategories as $category) {
            for ($i=0; $i < 10; $i++) { 
                foreach ($arItems as $key => $value) {
                    $itemsModel = new Items();
                    $itemsModel->active = 1;
                    $itemsModel->name = $value['name'];
                    $itemsModel->description = $value['description'];
                    $itemsModel->category_id = $category['id'];
                    $itemsModel->price = $value['price'];
                    $itemsModel->quantity = $value['quantity'];

                    if($itemsModel->save(false))
                    {
                        if(count($value['variants'])>0)
                        {
                            foreach ($value['variants'] as $keyVariant => $valueVariant) {
                                if($arParams[$valueVariant['parent_code']]['use_in_search'])
                                    $variantsModel = new IParametersSearch();
                                else
                                    $variantsModel = new IParametersSimple();

                                $variantsModel->item_id = $itemsModel->id;
                                $variantsModel->parameter_id = $arParams[$valueVariant['parent_code']]['id'];
                                $variantsModel->value = $valueVariant['code'];
                                $variantsModel->quantity = $valueVariant['quantity'];
                                $variantsModel->type = 'v';
                                $variantsModel->save();
                            }                    
                            
                        }
                        if(count($value['parameters'])>0)
                        {
                            foreach ($value['parameters'] as $keyParameter => $valueParameter) {
                                if($arParams[$keyParameter]['use_in_search'])
                                    $paramsModel = new IParametersSearch();
                                else
                                    $paramsModel = new IParametersSimple();

                                $paramsModel->item_id = $itemsModel->id;
                                $paramsModel->parameter_id = $arParams[$keyParameter]['id'];
                                $paramsModel->value = $valueParameter;
                                $paramsModel->type = 'p';
                                $paramsModel->save();
                            }                    
                            
                        } 
                        if(count($value['images'])>0)
                        {
                            foreach ($value['images'] as $keyImage => $valueImage) {
                                $itemsModel->attachImage(Yii::getAlias('@app/modules/admin/files/fixtures/').$valueImage.'.jpg');
                            }                    
                            
                        }                               
                    }
                }
            }
        }
      
    }

    public function truncateAll(){           
        Yii::$app->db->createCommand('TRUNCATE '.ListsToParameters::tableName())->execute();
        Yii::$app->db->createCommand('TRUNCATE '.ParamNames::tableName())->execute();
        Yii::$app->db->createCommand('TRUNCATE '.Categories::tableName())->execute();
        Yii::$app->db->createCommand('TRUNCATE '.VariantsToCategories::tableName())->execute();
        Yii::$app->db->createCommand('TRUNCATE '.ParametersToCategories::tableName())->execute();
    }

    public function truncateItems(){           
        Yii::$app->db->createCommand('TRUNCATE '.Items::tableName())->execute();
        Yii::$app->db->createCommand('TRUNCATE '.IParametersSearch::tableName())->execute();
        Yii::$app->db->createCommand('TRUNCATE '.IParametersSimple::tableName())->execute();
        Yii::$app->db->createCommand('TRUNCATE image')->execute();
    }    
}