<?php
namespace app\widgets\filter;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use Yii;

class RangeSlider extends FilterWidget{
	public $link = '';
	public $attributName = 'ids';
	public $gridId = 'grid';
	public $buttonText = '<span class="glyphicon glyphicon-trash"></span> Delete Selected';
	public $confirMsg = 'Are you sure you want to delete all selected items?';
	
	public function init(){
		$this->registerAssets();
	}
	
	public function run(){
        echo '<div class="range-slider-cont">';
            echo '<div class="nstSlider" data-range_min="100" data-range_max="10000" data-cur_min="2000" data-cur_max="8000">';
                echo '<div class="bar"></div>';
                echo '<div class="leftGrip"></div>';
                echo '<div class="rightGrip"></div>';
            echo '</div>';
            echo '<p class="range-info-cont">Price: <span class="leftLabel"></span>р - <span class="rightLabel"></span>р</p>';
            echo '<input type="hidden" id="price_left">';
            echo '<input type="hidden" id="price_right">';
            echo '<a class="range-filter-button pull-right" onclick="return urlTest(\''.self::currentPageWithParams().'\')" href="'.self::currentPageWithParams().'">Filter <i class="fa fa-chevron-right"></i></a>';
            echo '<div style="clear:both"></div>';
        echo '</div>'; 
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
        $('#price_left').val(leftValue);
        $('#price_right').val(rightValue);
        }
        });
    }
    function buildUrl(base, key, value) {
    var sep = (base.indexOf('?') > -1) ? '&' : '?';
    return base + sep + key + '=' + value;
}
    //Scale slider after document ready
    RangeSlider();
    function urlTest(url){
        var price = $('#price_left').val()+':'+$('#price_right').val()
        document.location = buildUrl(url,'filter[price]',price);
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
