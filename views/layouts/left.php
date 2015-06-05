<?php 
use app\widgets\filter\RangeSlider;
$this->beginContent('@app/views/layouts/main.php'); 

//$this->registerJs('$("document").ready(function(){ selectedVariant('.$variant['id_variant'].'); });');
?>
    <div class="container main-body">
        <div class="row">
            <div class="col-md-3 hidden-sm hidden-xs">
                <div class="left-menu-cont">
                    <div class="category-label">
                        <p>BRAND</p>
                    </div>
                    <ul>
                        <li><label><input class="filter-checkbox" type="checkbox"><span class="filter-checkbox-simul"><i class="glyphicon glyphicon-ok"></i></span>&nbsp; A.B.S. by Allen Schwartz</label></li>
                        <li><label><input class="filter-checkbox" type="checkbox"><span class="filter-checkbox-simul"><i class="glyphicon glyphicon-ok"></i></span>&nbsp; AG Adriano Goldshmeid</label></li>
                        <li><label><input class="filter-checkbox" type="checkbox"><span class="filter-checkbox-simul"><i class="glyphicon glyphicon-ok"></i></span>&nbsp; Alice & Olivia</label></li>
                        <li><label><input class="filter-checkbox" type="checkbox"><span class="filter-checkbox-simul"><i class="glyphicon glyphicon-ok"></i></span>&nbsp; Autumn Cashmere</label></li>
                        <li><label><input class="filter-checkbox" type="checkbox"><span class="filter-checkbox-simul"><i class="glyphicon glyphicon-ok"></i></span>&nbsp; BCBGMAXAZRIA</label></li>
                        <li><label><input class="filter-checkbox" type="checkbox"><span class="filter-checkbox-simul"><i class="glyphicon glyphicon-ok"></i></span>&nbsp; DKNY</label></li>
                        <li><label><input class="filter-checkbox" type="checkbox"><span class="filter-checkbox-simul"><i class="glyphicon glyphicon-ok"></i></span>&nbsp; Elie Tahari</label></li>
                        <li><label><input class="filter-checkbox" type="checkbox"><span class="filter-checkbox-simul"><i class="glyphicon glyphicon-ok"></i></span>&nbsp; Magaschoni</label></li>
                    </ul>

                    <div class="category-label">
                        <p>COLOR</p>
                    </div>
                    <ul>
                        <li><label><input class="filter-checkbox" type="checkbox"><span class="filter-checkbox-simul"><i class="glyphicon glyphicon-ok"></i></span>&nbsp; Beige  <span class="pull-right"><i class="glyphicon glyphicon-stop" style="color:#F0E8C4"></i></span></label> </li>
                        <li><label><input class="filter-checkbox" type="checkbox"><span class="filter-checkbox-simul"><i class="glyphicon glyphicon-ok"></i></span>&nbsp; Blue  <span class="pull-right"><i class="glyphicon glyphicon-stop" style="color:#2AD4FF"></i></span></label></li>
                        <li><label><input class="filter-checkbox" type="checkbox"><span class="filter-checkbox-simul"><i class="glyphicon glyphicon-ok"></i></span>&nbsp; Red  <span class="pull-right"><i class="glyphicon glyphicon-stop" style="color:#FF5555"></i></span></label></li>
                        <li><label><input class="filter-checkbox" type="checkbox"><span class="filter-checkbox-simul"><i class="glyphicon glyphicon-ok"></i></span>&nbsp; Green  <span class="pull-right"><i class="glyphicon glyphicon-stop" style="color:#81B600"></i></span></label></li>
                        <li><label><input class="filter-checkbox" type="checkbox"><span class="filter-checkbox-simul"><i class="glyphicon glyphicon-ok"></i></span>&nbsp; Multi </label>  </li>
                    </ul>   
                    <!-- Range Slider Start --> 
                    <div class="category-label">
                        <p>PRICE RANGE</p>
                    </div>                   
                    <?=RangeSlider::widget();?>  
                    <!-- Range Slide End -->    
                    <div class="category-label">
                        <p>BEST SELERS</p>
                    </div>
                    <div class="top-sale-cont">
                        <ul>
                            <li>
                                <div class="row">
                                    <div class="col-md-12"><a href="#"><img  src="site_photos/tshirt1.jpg" alt=""></a>
                                        <p class="t-s-title">Print Cool Interesting T-Shirt</p>
                                        <p class="t-s-price">1000р</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row">
                                    <div class="col-md-12"><a href="#"><img  src="site_photos/tshirt2.jpg" alt=""></a>
                                        <p class="t-s-title">State Island T-Shirt</p>
                                        <p class="t-s-price">2000р</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row">
                                    <div class="col-md-12"><a href="#"><img  src="site_photos/tshirt3.jpg" alt=""></a>
                                        <p class="t-s-title">Cool Underground T-Shirt</p>
                                        <p class="t-s-price">1500р</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row">
                                    <div class="col-md-12"><a href="#"><img  src="site_photos/tshirt4.jpg" alt=""></a>
                                        <p class="t-s-title">Enjoy Cool T-Shirt</p>
                                        <p class="t-s-price">5500р</p>
                                    </div>
                                </div>
                            </li>                                                       
                        </ul>
                    </div>  
<!--                    <div class="category-label">
                                            <p>Adverts</p>
                                        </div>                  
                                        <div class="left-advert-cont">
                                            <a href="#">
                                            <img src="site_photos/advert5.jpg" class="img-responsive" alt="Responsive image">
                                            </a>
                                        </div>   -->                                        
                </div>
            </div>
            <div class="col-md-9 col-sm-12 col-xs-12">
                <div class="row"> 
                    <div class="col-sm-12">
                        <!-- ---------------------------------- Mobile Left Menu Start -------------------------------------- -->
                        <script>
                            jQuery(document).ready(function ($) {
                                $('#collapseBrand, #collapseColor, #collapsePriceRange').on('hide.bs.collapse', function () {
                                    $(this).prev('div').find('i').removeClass().addClass('glyphicon glyphicon-plus');
                                });
                                $('#collapseBrand, #collapseColor, #collapsePriceRange').on('show.bs.collapse', function () {
                                    $(this).prev('div').find('i').removeClass().addClass('glyphicon glyphicon-minus');
                                });                             
                            });
                        </script>
                        <div class="mobile-left-menu-cont visible-xs-12  hidden-lg hidden-md hidden-sm ">   
                            <div class="category-label category-label-m">
                                <p data-toggle="collapse" href="#collapseBrand" aria-expanded="false" aria-controls="collapseBrand" >BRAND <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span></p>
                            </div>
                            <ul class="collapse" id="collapseBrand">
                                <li><a href="#">A.B.S. by Allen Schwartz</a></li>
                                <li><a href="#">AG Adriano Goldshmeid</a></li>
                                <li><a href="#">Alice & Olivia</a></li>
                                <li><a href="#">Autumn Cashmere</a></li>
                                <li><a href="#">BCBGMAXAZRIA</a></li>
                                <li><a href="#">DKNY</a></li>
                                <li><a href="#">Elie Tahari</a></li>
                                <li><a href="#">Magaschoni</a></li>
                            </ul>

                            <div class="category-label category-label-m">
                                <p data-toggle="collapse" href="#collapseColor" aria-expanded="false" aria-controls="collapseColor">COLOR <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span></p>
                            </div>
                            <ul class="collapse" id="collapseColor">
                                <li><a href="#">Beige </a> <span class="pull-right"><i class="glyphicon glyphicon-stop" style="color:#F0E8C4"></span></i> </li>
                                <li><a href="#">Blue </a> <span class="pull-right"><i class="glyphicon glyphicon-stop" style="color:#2AD4FF"></i></span></li>
                                <li><a href="#">Red </a> <span class="pull-right"><i class="glyphicon glyphicon-stop" style="color:#FF5555"></i></span></li>
                                <li><a href="#">Green </a> <span class="pull-right"><i class="glyphicon glyphicon-stop" style="color:#81B600"></i></span></li>
                                <li><a href="#">Multi </a>  </li>
                            </ul>                           
                            <!-- Range Slider Start --> 
                            <div class="category-label category-label-m">
                                <p data-toggle="collapse" href="#collapsePriceRange" aria-expanded="false" aria-controls="collapsePriceRange">PRICE RANGE <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span></p>
                            </div>
                            <div class="range-slider-cont collapse" id="collapsePriceRange">
                                <div class="nstSlider" data-range_min="100" data-range_max="10000" 
                                                       data-cur_min="2000"    data-cur_max="8000">

                                    <div class="bar"></div>
                                    <div class="leftGrip"></div>
                                    <div class="rightGrip"></div>
                                </div>
                                <p class="range-info-cont">Price: <span class="leftLabel"></span>р - <span class="rightLabel"></span>р</p>
                                <a class="range-filter-button pull-right" href="#">Filter <i class="fa fa-chevron-right"></i></a>
                                <div style="clear:both"></div>

                            </div>  
                            <!-- Range Slide End -->
                        </div>
                        <!-- ---------------------------------- Mobile Left Menu End -------------------------------------- --> 
                        <?= $content ?>
                    </div>
                </div>
            </div> 
        </div>
    </div>       
  
<?php $this->endContent(); ?>