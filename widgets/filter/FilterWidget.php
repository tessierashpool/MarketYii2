<?php
namespace app\widgets\filter;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Categories;
use app\models\Statistic;
use app\models\ParamNames;
use Yii;

class FilterWidget extends Widget{

    public $cid = '';
    private $_arCategories = [];
    private $_arValues = [];
    private $_arPrice = [];
    private $_arParamsInfo = [];
    public $arParams = ['brand','color','size'];
    public $filter = [];
    
    public function init(){
        $params = Yii::$app->request->get();
        if(count($params['filter'])>0)
        {
            $this->filter = $params['filter'];
        } 
        $this->_arCategories = Categories::getAllChildsByCode($params['c']);
        $this->_arParamsInfo = $this->getParamInfoWithCodeKey(); 
        $this->_arValues = $this->getValuesWithIdKey(); 
        $this->_arPrice = $this->getPriceRange(); 
        $this->registerAssets();
    }
    
    public function run()
    {
        $this->filterForm();
    }

    public function getPriceRange()
    {
        return Statistic::getAllItemsPriceRange($this->_arCategories);
    }

    public function saveFilterInSession()
    {
        $session = Yii::$app->session;

        $params = Yii::$app->request->post();
        if(count($params['filter'])>0)
        {
            $session->set('filter',$params['filter']);
            Yii::$app->getResponse()->redirect(Url::current(['page'=>null,'per-page'=>null]));
        }            
        if(isset($params['clear_filter']))
        {
            $session->remove('filter');
            Yii::$app->getResponse()->redirect(Url::current(['page'=>null,'per-page'=>null]));
        }            
        if($session->has('filter'))
            $this->filter = $session->get('filter');
    }

    public function getParamInfoWithCodeKey()
    {
        $arTmp = ParamNames::find()->with('valuesList')->where(['code'=>$this->arParams])->asArray()->all();
        $arResult = [];
        foreach ($arTmp as $key => $value) {
            $arResult[$value['code']] = $value;
        }
        return $arResult;
    }

    public function getValuesWithIdKey()
    {
        $params = Yii::$app->request->get();
        $category_id = Categories::getIdByCode($params['c']);
        $cache = Yii::$app->cache;
        $dependency = new \yii\caching\DbDependency(['sql' => 'SELECT  max( id ) + (SELECT max( id ) FROM `lists_to_parameters` ) FROM `i_parameters_search`']);
        //$cache->flush();
        $arResult = $cache->get('stat_filter_val_'.$category_id);
        if ($arResult === false) {
            $arTmp = Statistic::getAllParametersValuesInCategory($this->_arCategories);
            $arResult = [];
            foreach ($arTmp as $key => $value) {
                $arResult[$value['parameter_id']][] = $value;
            }
            $cache->set('stat_filter_val_'.$category_id, $arResult,60*60*24*7,$dependency);
        }
        return $arResult;
    }

    /*Filter form*/
    public function filterForm(){
        $filter=$this->filter;
        $csrfParam = Yii::$app->request->csrfParam;
        $csrfToken = Yii::$app->request->csrfToken;          
        echo '<form method="GET" action="">';
        if(Yii::$app->request->get('c')!='')
            echo '<input name="c" value="'.Yii::$app->request->get('c').'" type="hidden">';

        //echo '<input name="'.$csrfParam.'" value="'.$csrfToken.'" type="hidden">';
        $this->getFilters();        
        $this->rangeSlider();             
        if(count($filter)>0)
        {
            echo '<button class="filter-button pull-left active" type="submit" >Filter <i class="fa fa-chevron-right"></i></button>';
            echo '<button class="filter-button pull-left" name="clear_filter" onclick="goTo(\''.Url::current(['filter'=>null]).'\');return false;"  >Clear Filter <i class="glyphicon glyphicon-remove"></i></button>';
        }
        else
        {
            echo '<button class="filter-button pull-left" type="submit" >Filter <i class="fa fa-chevron-right"></i></button>';
        } 
        echo '<div style="clear:both"></div>';
        echo '</div>';  
        echo '</form>';
    }
    /*Filter form*/
    public function getFilters()
    {
        foreach($this->arParams as $code) 
        {
            $this->filterValuesList($code);
        }
    }

    /*Generate filter for selected parameter*/
    public function filterValuesList($code)
    {
        $arParam = $this->_arParamsInfo[$code];
        $filter =$this->filter;
        $arValues = $this->_arValues[$arParam['id']];
        if(count($arValues)>0)
        {
            echo '<div class="category-label">';
                echo '<p>'.$arParam['name'].'</p>';
            echo '</div>';
            echo '<ul>';
                if($arParam['type']!='list')
                {
                    foreach ($arValues as  $value) 
                    {
                        $checked = '';
                        if(isset($filter[$arParam['id']])&&in_array($value['value'],$filter[$arParam['id']]))
                            $checked = 'checked';
                        echo '<li><label><input '.$checked.' name="filter['.$arParam['id'].'][]" value="'.$value['value'].'" class="filter-checkbox" type="checkbox"><span class="filter-checkbox-simul"><i class="glyphicon glyphicon-ok"></i></span>&nbsp; '.$value['value'].'</label> </li>';
                    }
                    
                }
                else
                {
                    foreach ($arParam['valuesList'] as  $listValue) 
                    {
                        foreach ($arValues as $value) 
                        {       
                            if($listValue['code'] == $value['value'])
                            {
                                $checked = '';
                                if(isset($filter[$arParam['id']])&&in_array($value['value'],$filter[$arParam['id']]))
                                    $checked = 'checked';                               
                                echo '<li><label><input '.$checked.' name="filter['.$arParam['id'].'][]" value="'.$value['value'].'" class="filter-checkbox" type="checkbox"><span class="filter-checkbox-simul"><i class="glyphicon glyphicon-ok"></i></span>&nbsp; '.$listValue['value'].'</label> </li>';                            
                            }                  
                        }                  
                    }                 
                }
            echo '</ul>'; 
        }
    }

    /*Color selector*/
    public function colorSelector()
    {
        //var_dump($this->_arColor);
        echo '<div class="category-label">';
            echo '<p>COLOR</p>';
        echo '</div>';
        echo '<ul>';
            foreach($this->_arColor['valuesList'] as $color)
            {
                foreach ($this->_arValues as $key => $value) {
                    if($value['parameter_id']==$this->_arColor['id']&&$value['value']==$color['code'])
                    {
                        echo '<li><label><input name="filter[color]" value="'.$color['code'].'" class="filter-checkbox" type="checkbox"><span class="filter-checkbox-simul"><i class="glyphicon glyphicon-ok"></i></span>&nbsp; '.$color['value'].'</label> </li>';
                        //echo '<li><label><input name="filter[color]" value="'.$color['code'].'" class="filter-checkbox" type="checkbox"><span class="filter-checkbox-simul"><i class="glyphicon glyphicon-ok"></i></span>&nbsp; '.$color['value'].'  <span class="color-viewer pull-right"><i class="glyphicon glyphicon-stop" style="color:'.$color['code'].'"></i></span></label> </li>';
                    }
                }
                
            }
        echo '</ul>'; 
    }

    /*Price Range Slider*/
    public function rangeSlider()
    {
        $priceRange = $this->_arPrice;
        $filter=$this->filter;
        $arPrice = [];
        if($filter['price']!='')
        {
            $arPrice = explode(':',$filter['price']);
        }
        echo '<div class="category-label">';
            echo '<p>PRICE RANGE</p>';
        echo '</div>';         
        echo '<div class="range-slider-cont">';
            if(count($arPrice)>0)
                echo '<div class="nstSlider" data-range_min="'.$priceRange['min'].'" data-range_max="'.$priceRange['max'].'" data-cur_min="'.$arPrice[0].'" data-cur_max="'.$arPrice[1].'">';
            else
                echo '<div class="nstSlider" data-range_min="'.$priceRange['min'].'" data-range_max="'.$priceRange['max'].'" data-cur_min="'.$priceRange['min'].'" data-cur_max="'.$priceRange['max'].'">';
               
                echo '<div class="bar"></div>';
                echo '<div class="leftGrip"></div>';
                echo '<div class="rightGrip"></div>';
            echo '</div>';
            echo '<p class="range-info-cont">Price: <span class="leftLabel"></span>р - <span class="rightLabel"></span>р</p>';
            echo '<input type="hidden" name="filter[price]" id="filter_price">';
    }

    public function registerAssets()
    {
        $view = $this->getView();
        $registerFunction = <<< JS
    function RangeSlider() {
        $('.nstSlider').nstSlider({
        "left_grip_selector": ".leftGrip",
        "right_grip_selector": ".rightGrip",
        "value_bar_selector": ".bar",
        "value_changed_callback": function(cause, leftValue, rightValue) {
        $(this).parent().find('.leftLabel').text(leftValue);
        $(this).parent().find('.rightLabel').text(rightValue);
        $(this).parent().find('#filter_price').val(leftValue+':'+rightValue);
        }
        });
    }
    function buildUrl(base, key, value) {
        var sep = (base.indexOf('?') > -1) ? '&' : '?';
        return base + sep + key + '=' + value;
    }
    //Scale slider after document ready
    RangeSlider();
    function goTo(url){
        var price = $('#price_left').val()+':'+$('#price_right').val()
        document.location = url;
        return false;
    }                                    
    //Scale slider while window load/resize/orientationchange.
    $(window).bind("load", RangeSlider);
    $(window).bind("resize", RangeSlider);
    $(window).bind("orientationchange", RangeSlider);  
JS;
        $view->registerJs($registerFunction,yii\web\View::POS_END);
    }

    public static function currentPageWithParams($arAddParams=array(),$arDelParams=array())
    {   
        $tmp = explode('?',$_SERVER['REQUEST_URI']);
        $tmp_params = array();
        if(isset($tmp[1]))
            $tmp_params = explode('&',$tmp[1]);
            
        $arParams = array();
        foreach($tmp_params as $param)
        {
            $paramNameValAr = explode('=',$param);
            if(!in_array($paramNameValAr[0],$arDelParams))
                $arParams[$paramNameValAr[0]] = $paramNameValAr[1];
        }

        $arParamsMerged = array_merge($arAddParams,$arParams);
        foreach($arParamsMerged as $key=>$value)
        {
            if($value!='')
                $newUrlParams[] = $key.'='.$value;
            else
                $newUrlParams[] = $key;
        }
        if(count($newUrlParams)>0)
        {
            $newUrlParams = implode('&',$newUrlParams);
            $newUrl = $tmp[0].'?'.$newUrlParams;
        }
        else
        {
            $newUrl = $tmp[0];
        }
        return $newUrl;
    }    	
}
?>
