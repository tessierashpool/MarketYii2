<?php
namespace app\widgets\topMenu;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Categories;
use Yii;

class TopMenu extends Widget{

    public $cid = '';
    private $_arCategories = [];
    private $_arValues = [];
    
    public function init(){
        $this->_arCategories = $this->getArCategory();
        $this->registerAssets();
    }
    public function getArCategory(){
        $arTmpCat = (new Categories)->getTree(); 
        $arMainCat = []; 
        foreach($arTmpCat as $key1=>$cat) 
        {
            if($cat['depth']==null)
            {
                $arMainCat[$cat['id']]=$cat;
                unset($arTmpCat[$key1]);
                foreach($arTmpCat as $key2=>$subCat) 
                {
                    if($subCat['parent_id']==$cat['id'])
                    {
                        $arMainCat[$cat['id']]['sub'][$subCat['id']] = $subCat;
                        unset($arTmpCat[$key2]);
                        foreach($arTmpCat as $key3=>$subSubCat) 
                        {
                            if($subSubCat['parent_id']==$subCat['id'])
                            {
                                $arMainCat[$cat['id']]['sub'][$subCat['id']]['sub'][$subSubCat['id']] = $subSubCat;
                                unset($arTmpCat[$key3]);
                            }
                        }                        
                    }
                }
            }
        }   
        return $arMainCat; 
    }

    public function run()
    {
        return $this->generateMenu();
    }
    function generateMenu(){
        $cache = Yii::$app->cache;
        $dependency = new \yii\caching\DbDependency(['sql' => 'SELECT MAX(updated_at) FROM `categories`']);
        $menu = $cache->get('menu');
        if ($menu === false) {
            $cat =  $this->_arCategories;
            $menu = '';
            $menu .= '<ul  class=" pull-left">';
            foreach($cat as $k1=>$c)
            {
                $menu .= '<li ><a class="menu-link" href="'.Url::to(['', 'c' => $c['code']]).'">'.$c['name'].' <i class="fa fa-angle-down"></i></a>';
                $menu .= '<div class="submenu">';
                $menu .= '<div class="submenu-left pull-left">';            
                $counter = 1;
                if(count($c['sub'])>0)
                {
                    $menu .= '<ul 11>';
                    foreach($c['sub'] as $k2=>$sc)
                    {
                        $active = '';
                        if($counter==1)
                            $active = 'sub-first-link active';

                        $arrow = '';
                        if(count($sc['sub'])>0)
                            $arrow = '<i class="fa fa-angle-right"></i>';
                        $menu .= '<li><a href="'.Url::to(['', 'c' => $sc['code']]).'" data-num="'.$counter.'" class="'.$active.'">'.$sc['name'].' '.$arrow.'</a></li>';
                        $counter++;
                    }
                    $menu .= '</ul >';
                }            
                $menu .= '</div>';
                $menu .= '<div class="submenu-right pull-left">';
                $counter = 1;
                if(count($c['sub'])>0)
                {
                    foreach($c['sub'] as $k2=>$sc)
                    {
                        $active = '';
                        if($counter==1)
                            $active = 'active';

                        $menu .= '<ul class="sub-sub-menu sub-sub-menu-'.$counter.' '.$active.'">';
                        $counter++;
                        if(count($sc['sub'])>0)
                        {
                            foreach($sc['sub'] as $k3=>$ssc)
                            {
                                $menu .= '<li><a  href="'.Url::to(['', 'c' => $ssc['code']]).'"><span>'.$ssc['name'].'</span> </a></li>';
                            }
                        }
                        $menu .= '</ul>';
                    }
                }
                $menu .= '</div>';
                $menu .= '</div>';
                $menu .= '</li>';
            }
            $menu .= '</ul>';
            $cache->set('menu', $menu,60*60*24*7,$dependency);
        }
        
        return $menu;            
    }
    public function registerAssets()
    {
        $view = $this->getView();
        $registerFunction = <<< JS
    function menuInit(){

        $('.submenu').each(function(){
            var left_height = $(this).children('.submenu-left').children('ul').innerHeight();
            var right_height = -1;
            $(this).children('.submenu-right').children('ul').each(function() {
                var h = $(this).height(); 
                right_height = h > right_height ? h : right_height;
            }); 

            var max_right_width = -1;
            $(this).find('span').each(function(){
                    var w = $(this).width(); 
                    max_right_width = w > max_right_width ? w : max_right_width;
            }); 
            var outerD=0;
            randomA = $(this).find('a');
            outerD = parseInt(randomA.css('margin-left'));
            outerD += parseInt(randomA.css('margin-right'));
            outerD += parseInt(randomA.css('padding-right'));
            outerD += parseInt(randomA.css('padding-left'));
            if((max_right_width)+outerD>150)
            {
                $(this).children('.submenu-right').find('li').width(max_right_width+30);
                $(this).width(max_right_width+$('.submenu-right').width()+30);
            }
            $(this).height(left_height>right_height?left_height:right_height);      
            $(this).css('visibility','visible');
            $(this).css('display','none');
        });

        $('.submenu-left ul li a').hover(function(){
            $('.submenu-left ul li a').removeClass('active');
            $('.sub-sub-menu').css('visibility','visible');
            $('.sub-sub-menu').css('display','none');
            $('.sub-sub-menu-'+$(this).data('num')).css('display','block');
            $(this).addClass('active');
        });

        $('.menu-link').hover(function(){
            $(this).next('.submenu').find('a').removeClass('active');
            $('.sub-sub-menu').css('display','none');
            $('.sub-sub-menu-1').css('display','block');
            $(this).next('.submenu').find('.sub-first-link').addClass('active');            
        });     
    }
    menuInit(); 
JS;
        $view->registerJs($registerFunction,yii\web\View::POS_END);
    }    	
}
?>
