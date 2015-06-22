<?php
namespace app\widgets\topMenu;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Categories;
use Yii;

class TopMenu extends Widget{

    public $mobile = false;
    private static $_arCategories = [];
    
    public function init(){
        if(empty(self::$_arCategories))
            self::$_arCategories = $this->getArCategory();
        $this->registerAssets();
    }
    public function getArCategory(){
        $cache = Yii::$app->cache;
        $dependency = new \yii\caching\DbDependency(['sql' => 'SELECT MAX(updated_at) FROM `categories`']);
        //$cache->flush();
        $arMainCat = $cache->get('menu');
        if ($arMainCat === false) {
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
            $cache->set('menu', $arMainCat,60*60*24*7,$dependency);
        } 
        return $arMainCat; 
    }

    public function run()
    {
        if($this->mobile)
            return $this->generateMobileMenu();
        else
            return $this->generateMenu();
    }
   public function generateMobileMenu(){    
        $cookies = Yii::$app->request->cookies;
        $cartLightHtml = '';
        if($cookies->has('cart'))
        {
            $cart = $cookies['cart']->value; 
            $cartCount =count($cart);    
            if($cartCount>0)  
                $cartLightHtml = '<span>'.$cartCount.'</span>';
        }       

        $cat =  self::$_arCategories;
        $menu = '';
        $menu .= '<nav style="margin-bottom:-1px" class="navbar navbar-default" role="navigation">';
                $menu .= '<div class="navbar-header">';
                    $menu .= '<button type="button" class="navbar-toggle collapsed pull-right" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">';
                        $menu .= '<span class="sr-only">Toggle navigation</span>';
                        $menu .= '<span class="icon-bar"></span>';
                        $menu .= '<span class="icon-bar"></span>';
                        $menu .= '<span class="icon-bar"></span>';
                    $menu .= '</button>';
                    $menu .= '<a class="navbar-brand mobile-header" href="'.Yii::$app->homeUrl.'">';
                        $menu .= '<div class="logo pull-left"></div>';                  
                        $menu .= '<span class="pull-right shop-name">'.Yii::$app->name.'</span>';
                    $menu .= '</a>'; 
                $menu .= '</div>';
                $menu .= '<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">';
                    $menu .= '<ul class="nav navbar-nav">';   
                    foreach($cat as $k1=>$c)            
                    {
                        $menu .= '<li class="dropdown">';
                            $menu .= '<a href="'.Url::to(['index', 'c' => $c['code']]).'" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">'.$c['name'].' <span class="caret"></span></a>';
                            $menu .= '<ul class="dropdown-menu" role="menu">';
                                if(count($c['sub'])>0)
                                {
                                    foreach ($c['sub'] as $k2 => $sc) {
                                        $menu .= '<li><a href="'.Url::to(['index', 'c' => $sc['code']]).'">'.$sc['name'].'</a></li>';
                                        /* if(count($sc['sub'])>0)
                                        {
                                            foreach ($sc['sub'] as $k3 => $ssc) {
                                                $menu .= '<li><a href="'.Url::to(['', 'c' => $ssc['code']]).'">'.$ssc['name'].'</a></li>';
                                            }
                                            $menu .= '<li role="separator" class="divider"></li>';
                                        }*/                                       
                                    }
                                     $menu .= '<li role="separator" class="divider"></li>';
                                }
                            $menu .= '</ul>';
                        $menu .= '</li>';                         
                    }                                              
                    $menu .= '</ul>';       
                    $menu .= '<ul class="nav navbar-nav">';
                        $menu .= '<li><a href="#"><i class="glyphicon glyphicon-star"></i> Whishlist</a></li>';
                        $menu .= '<li><a href="'.Url::to(['cart']).'"><i class="glyphicon glyphicon-shopping-cart"></i> Cart <span class="cart-light">'.$cartLightHtml.'</span></a></li>';
                        $menu .= '<li>';
                            if(Yii::$app->user->isGuest)
                                $menu .= '<a href="'.Url::to(['login']).'"><i class="glyphicon glyphicon-lock"></i> Login</a>';
                            else
                                $menu .= '<a href="'.Url::to(['logout']).'"><i class="glyphicon glyphicon-log-out"></i> Logout</a>';
                        $menu .= '</li>';                                             
                    $menu .= '</ul>';                                       
                $menu .= '</div>';          
            $menu .= '</nav>';             
        return $menu;            
    }

    public function generateMenu(){       
        $cat =  self::$_arCategories;
        $menu = '';
        $menu .= '<ul  class=" pull-left">';
        foreach($cat as $k1=>$c)
        {
            $menu .= '<li ><a class="menu-link" href="'.Url::to(['index', 'c' => $c['code']]).'">'.$c['name'].' <i class="fa fa-angle-down"></i></a>';
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
                    $menu .= '<li><a href="'.Url::to(['index', 'c' => $sc['code']]).'" data-num="'.$counter.'" class="'.$active.'">'.$sc['name'].' '.$arrow.'</a></li>';
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
                            $menu .= '<li><a  href="'.Url::to(['index', 'c' => $ssc['code']]).'"><span>'.$ssc['name'].'</span> </a></li>';
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
