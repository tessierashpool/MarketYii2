<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
$this->title = 'E-SHOP';
$this->registerJs("
    jQuery(document).ready(function ($) {
        var options = {
            \$AutoPlay: true,
            \$SlideDuration: 1000,
            \$AutoPlayInterval: 4000,
            \$BulletNavigatorOptions: {
                \$Class: \$JssorBulletNavigator$,
                \$ChanceToShow: 2,
                \$AutoCenter: 1,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                \$Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                \$Lanes: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                \$SpacingX: 10,                                  //[Optional] Horizontal space between each item in pixel, default value is 0
                \$SpacingY: 10,                                  //[Optional] Vertical space between each item in pixel, default value is 0
                \$Orientation: 1                  
            }
        };                          
        var jssor_slider1 = new \$JssorSlider$('slider1_container', options);

        //responsive code begin
        //you can remove responsive code if you don't want the slider scales
        //while window resizes
        function ScaleSlider() {
            var parentWidth = $('#slider1_container').parent().width();
            if (parentWidth) {
                jssor_slider1.\$ScaleWidth(parentWidth);
            }
            else
                window.setTimeout(ScaleSlider, 30);
        }
        //Scale slider after document ready
        ScaleSlider();
                                        
        //Scale slider while window load/resize/orientationchange.
        $(window).bind('load', ScaleSlider);
        $(window).bind('resize', ScaleSlider);
        $(window).bind('orientationchange', ScaleSlider);
        //responsive code end
    });",\yii\web\View::POS_BEGIN);
?>
                        <div class="main-content-banner hidden-xs">
                            <div id="slider1_container" style="position: relative; top: 0px; left: 0px; width: 848px; height: 400px; overflow: hidden;">
                                <!-- Slides Container -->
                                <div u="slides" style="  position: absolute; overflow: hidden; left: 0px; top: 0px; width: 848px; height: 400px;">
                                    <div class="slide-cont">
                                        <div class="slide-content-cont">
                                            <img class="slider-img" src="site_photos/girl1.png" alt="">
                                        </div>
                                        <div class="slide-title-cont">
                                            <p><span>Interesting</span> Title</p>
                                        </div>
                                        <div class="slide-description-cont">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                        </div>          
                                        <div class="slide-button-cont" >
                                            <a href="#" >Buy it now</a>
                                        </div>                                                                  
                                    </div>
                                    <div class="slide-cont">
                                        <div class="slide-content-cont">
                                            <img class="slider-img" src="site_photos/girl2.png" alt="">
                                        </div>
                                        <div class="slide-title-cont">
                                            <p><span>Interesting</span> Title</p>
                                        </div>
                                        <div class="slide-description-cont">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                        </div>          
                                        <div class="slide-button-cont" >
                                            <a href="#" >Buy it now</a>
                                        </div>                                                                  
                                    </div>
                                    <div class="slide-cont">
                                        <div class="slide-content-cont">
                                            <img class="slider-img" src="site_photos/girl3.png" alt="">
                                        </div>
                                        <div class="slide-title-cont">
                                            <p><span>Interesting</span> Title</p>
                                        </div>
                                        <div class="slide-description-cont">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                        </div>          
                                        <div class="slide-button-cont" >
                                            <a href="#" >Buy it now</a>
                                        </div>                                                                  
                                    </div>         
                                </div>
                                    <!-- Bullet Navigator Skin Begin -->
                                    <style>
                                        /* jssor slider bullet navigator skin 21 css */
                                        /*
                                        .jssorb21 div           (normal)
                                        .jssorb21 div:hover     (normal mouseover)
                                        .jssorb21 .av           (active)
                                        .jssorb21 .av:hover     (active mouseover)
                                        .jssorb21 .dn           (mousedown)
                                        */
                                        .jssorb21 div, .jssorb21 div:hover, .jssorb21 .av
                                        {
                                            background: url(./marketAssetsFiles/jssor/img/b21.png) no-repeat;
                                            overflow:hidden;
                                            cursor: pointer;
                                        }
                                        .jssorb21 div { background-position: -5px -5px; }
                                        .jssorb21 div:hover, .jssorb21 .av:hover { background-position: -35px -5px; }
                                        .jssorb21 .av { background-position: -65px -5px; }
                                        .jssorb21 .dn, .jssorb21 .dn:hover { background-position: -95px -5px; }
                                    </style>
                                    <!-- bullet navigator container -->
                                    <div u="navigator" class="jssorb21" style="position: absolute; bottom: 16px; left: 6px;">
                                        <!-- bullet navigator item prototype -->
                                        <div u="prototype" style="POSITION: absolute; WIDTH: 19px; HEIGHT: 19px; text-align:center; line-height:19px; color:White; font-size:12px;"></div>
                                    </div>
                                    <!-- Bullet Navigator Skin End -->
                                <!-- Trigger -->
                                <script>jssor_slider1_starter('slider1_container');</script>
                            </div>
                        </div>
                        <div class="row main-cont-advert hidden-xs">
                            <div class="col-sm-6" >
                                <div class=" advert-cont-m">
                                    <div class="advert-cont-inner">
                                        <img src="site_photos/advertwomen.png" class="advert-cont-img-1 " alt="Responsive image">
                                        <div class="advert-button-cont">
                                            <a href="#">Show it now</a>
                                        </div>
                                        <div class="advert-title-cont">
                                            <p><span>Women Shoe</span> Collection</p>
                                        </div>
                                        <div class="advert-title-descr">
                                            <p>Elie Tahari 1-15 April</p>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6  ">
                                <div class=" advert-cont-m">
                                    <div class="advert-cont-inner">
                                        <img src="site_photos/advertmen.png" class="advert-cont-img-2" alt="Responsive image">
                                        <div class="advert-button-cont">
                                            <a href="#">Show it now</a>
                                        </div>
                                        <div class="advert-title-cont">
                                            <p><span>Men Shoe</span> Collection</p>
                                        </div>
                                        <div class="advert-title-descr">
                                            <p>Elie Tahari 1-15 April</p>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?= $this->render('items_list',['dataProvider'=>$dataProvider]) ?>
