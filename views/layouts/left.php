<?php 
use app\widgets\filter\FilterWidget;
use yii\widgets\Breadcrumbs;
$this->beginContent('@app/views/layouts/main.php'); 

//$this->registerJs('$("document").ready(function(){ selectedVariant('.$variant['id_variant'].'); });');
?>
    <div class="container-fluid breadcrumb-cont hidden-xs">
        <div class="row">
            <div class="">
                <div class="container">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>                        
                </div>              
            </div>              
        </div>              
    </div>  
    <div class="container main-body">
        <div class="row">
            <div class="col-md-3 hidden-sm hidden-xs">
                <div class="left-menu-cont">
                    <!-- Filte widget -->                  
                    <?=FilterWidget::widget([]);?>     
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

                        <!-- ---------------------------------- Mobile Left Menu End -------------------------------------- --> 
                        <?= $content ?>
                    </div>
                </div>
            </div> 
        </div>
    </div>       
  
<?php $this->endContent(); ?>