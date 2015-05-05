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
                                    <div >
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <div class="baner-info" >
                                                        <p class="baner-logo"><span style="color:#FF9933">Interesting</span> Title</p>
                                                        <p class="baner-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                                                        <a href="#" class="baner-link">Buy it now</a>
                                                    </div>
                                                </div>
                                                <div class="col-sm-7">
                                                    <img src="site_photos/shop_1.jpg" class="img-responsive" alt="Responsive image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div >
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <div class="baner-info" >
                                                        <p class="baner-logo"><span style="color:#FF9933">Interesting</span> Title</p>
                                                        <p class="baner-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                                                        <a href="#" class="baner-link">Buy it now</a>
                                                    </div>
                                                </div>
                                                <div class="col-sm-7">
                                                    <img src="site_photos/shop_2.jpg" class="img-responsive" alt="Responsive image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div >
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <div class="baner-info" >
                                                        <p class="baner-logo"><span style="color:#FF9933">Interesting</span> Title</p>
                                                        <p class="baner-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                                                        <a href="#" class="baner-link">Buy it now</a>
                                                    </div>
                                                </div>
                                                <div class="col-sm-7">
                                                    <img src="site_photos/shop_3.jpg" class="img-responsive" alt="Responsive image">
                                                </div>
                                            </div>
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
                                    <div class="row">
                                        <div class="col-sm-5 ">
                                            <img src="site_photos/shoe_1.jpg" class="img-responsive" alt="Responsive image">
                                        </div>
                                        <div   class="col-sm-7">
                                            <p class="a-title"><span style="color:#FF9933">Women Shoe</span> Collection</p>
                                            <p class="a-descr hidden-md hidden-sm" >Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                            <p ><a class="a-link pull-right" href="#">Show now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6  ">
                                <div class=" advert-cont-m">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <img src="site_photos/shoe_2.jpg" class="img-responsive" alt="Responsive image">
                                        </div>
                                        <div   class="col-sm-7">
                                            <p class="a-title"><span style="color:#FF9933">Man Shoe</span> Collection</p>
                                            <p class="a-descr hidden-md hidden-sm" >Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                            <p><a class="a-link pull-right" href="#">Show now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row main-content">
                            <div class="col-sm-4">
                                <div class="item-cont">
                                    <img src="site_photos/girl1.jpg" class="img-responsive" alt="Responsive image">
                                    <p class="i-price">1500 р</p>
                                    <p class="i-title"><a href="<?=Url::to(['detail']);?>">Simple Print T-Shirt</a></p>
                                    <a class="i-add-cart-link" href="#">Add to cart <i class="glyphicon glyphicon-shopping-cart"></i></a>
                                    <div class="corner-ribbon top-right sticky red">NEW</div>
                                    <div class="add-to-wishlist-cont">
                                        <a title="Add to wishlist" href="#"><i class="glyphicon glyphicon-star"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="item-cont">
                                    <img src="site_photos/girl2.jpg" class="img-responsive" alt="Responsive image">
                                    <p class="i-price">1500 р</p>
                                    <p class="i-title"><a href="#">Simple Print T-Shirt</a></p>
                                    <a class="i-add-cart-link" href="#">Add to cart <i class="glyphicon glyphicon-shopping-cart"></i></a>
                                    <div class="add-to-wishlist-cont">
                                        <a title="Add to wishlist" href="#"><i class="glyphicon glyphicon-star"></i></a>
                                    </div>                              
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="item-cont">
                                    <img src="site_photos/girl3.jpg" class="img-responsive" alt="Responsive image">
                                    <p class="i-price">1500 р</p>
                                    <p class="i-title"><a href="#">Simple Print T-Shirt</a></p>
                                    <a class="i-add-cart-link" href="#">Add to cart <i class="glyphicon glyphicon-shopping-cart"></i></a>
                                    <div class="add-to-wishlist-cont">
                                        <a title="Add to wishlist" href="#"><i class="glyphicon glyphicon-star"></i></a>
                                    </div>                              
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="item-cont">
                                    <img src="site_photos/girl4.jpg" class="img-responsive" alt="Responsive image">
                                    <p class="i-price">1500 р</p>
                                    <p class="i-title"><a href="#">Simple Print T-Shirt</a></p>
                                    <a class="i-add-cart-link" href="#">Add to cart <i class="glyphicon glyphicon-shopping-cart"></i></a>
                                    <div class="add-to-wishlist-cont">
                                        <a title="Add to wishlist" href="#"><i class="glyphicon glyphicon-star"></i></a>
                                    </div>                              
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="item-cont">
                                    <img src="site_photos/girl5.jpg" class="img-responsive" alt="Responsive image">
                                    <p class="i-price">1500 р</p>
                                    <p class="i-title"><a href="#">Simple Print T-Shirt</a></p>
                                    <a class="i-add-cart-link" href="#">Add to cart <i class="glyphicon glyphicon-shopping-cart"></i></a>
                                    <div class="corner-ribbon top-right sticky orange">SALE</div>
                                    <div class="add-to-wishlist-cont">
                                        <a title="Add to wishlist" href="#"><i class="glyphicon glyphicon-star"></i></a>
                                    </div>                              
                                </div>

                            </div>
                            <div class="col-sm-4">
                                <div class="item-cont">
                                    <img src="site_photos/girl6.jpg" class="img-responsive" alt="Responsive image">
                                    <p class="i-price">1500 р</p>
                                    <p class="i-title"><a href="#">Simple Print T-Shirt</a></p>
                                    <a class="i-add-cart-link" href="#">Add to cart <i class="glyphicon glyphicon-shopping-cart"></i></a>
                                    <div class="add-to-wishlist-cont">
                                        <a title="Add to wishlist" href="#"><i class="glyphicon glyphicon-star"></i></a>
                                    </div>                              
                                </div>
                            </div>                          
                            <div class="col-sm-4">
                                <div class="item-cont">
                                    <img src="site_photos/girl1.jpg" class="img-responsive" alt="Responsive image">
                                    <p class="i-price">1500 р</p>
                                    <p class="i-title"><a href="#">Simple Print T-Shirt</a></p>
                                    <a class="i-add-cart-link" href="#">Add to cart <i class="glyphicon glyphicon-shopping-cart"></i></a>
                                    <div class="add-to-wishlist-cont">
                                        <a title="Add to wishlist" href="#"><i class="glyphicon glyphicon-star"></i></a>
                                    </div>                              
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="item-cont">
                                    <img src="site_photos/girl2.jpg" class="img-responsive" alt="Responsive image">
                                    <p class="i-price">1500 р</p>
                                    <p class="i-title"><a href="#">Simple Print T-Shirt</a></p>
                                    <a class="i-add-cart-link" href="#">Add to cart <i class="glyphicon glyphicon-shopping-cart"></i></a>
                                    <div class="add-to-wishlist-cont">
                                        <a title="Add to wishlist" href="#"><i class="glyphicon glyphicon-star"></i></a>
                                    </div>                          
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="item-cont">
                                    <img src="site_photos/girl3.jpg" class="img-responsive" alt="Responsive image">
                                    <p class="i-price">1500 р</p>
                                    <p class="i-title"><a href="#">Simple Print T-Shirt</a></p>
                                    <a class="i-add-cart-link" href="#">Add to cart <i class="glyphicon glyphicon-shopping-cart"></i></a>
                                    <div class="add-to-wishlist-cont">
                                        <a title="Add to wishlist" href="#"><i class="glyphicon glyphicon-star"></i></a>
                                    </div>                              
                                </div>
                            </div>      
                            <div class="nav-cont text-center">
                                <nav>
                                  <ul class="pagination">
                                    <li>
                                      <a href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                      </a>
                                    </li>
                                    <li><a href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">4</a></li>
                                    <li><a href="#">5</a></li>
                                    <li>
                                      <a href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                      </a>
                                    </li>
                                  </ul>
                                </nav>                              
                            </div>              
                        </div>