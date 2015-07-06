<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\widgets\topMenu\TopMenu;
use app\assets\MarketAsset;
use yii\helpers\Url;
use app\models\Cart;
use app\models\Whishlist;
/* @var $this \yii\web\View */
/* @var $content string */

MarketAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <?= Html::csrfMetaTags() ?>  
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>  
<?php $this->beginBody() ?>
    <div class="container hidden-xs">
        <div class="row">
            <div class="col-sm-4">  
                <a href="<?=Yii::$app->homeUrl?>">           
                <div class="logo pull-left"></div>
                <p class="shop-name pull-left"><?=Yii::$app->name?></p>    
                </a>             
            </div>
            <div class="col-sm-8">              
                <p class="pull-right header-menu"> 
                    <a href="<?=Url::to(['whishlist']);?>"><i class="glyphicon glyphicon-heart"></i> Whishlist <span class="whishlist-light"><?=Whishlist::whishlistLight()?></span></a>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="<?=Url::to(['cart']);?>"><i class="glyphicon glyphicon-shopping-cart"></i> Cart <span class="cart-light"><?=Cart::cartLight()?></span></a>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?if(Yii::$app->user->isGuest):?>
                        <a href="<?=Url::to(['login']);?>"><i class="glyphicon glyphicon-log-in"></i> Login</a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="<?=Url::to(['signup']);?>"><i class="glyphicon glyphicon-user"></i> Sign up</a>
                    <?else:?>
                        <a  href="<?=Url::to(['account']);?>"><i class="glyphicon glyphicon-user"></i> Account</a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                     
                        <?if(Yii::$app->user->can('admin_panel')):?>
                            <a  href="<?=Url::to(['admin/default']);?>"><i class="glyphicon glyphicon-king"></i> Admin</a>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                        <?endif;?>
                        <a data-method = "post" href="<?=Url::to(['logout']);?>"><i class="glyphicon glyphicon-log-out"></i> Logout</a>
                    <?endif;?>
                </p>                
            </div>
        </div>      
    </div>
    <div class="container-fluid visible-xs-12  hidden-lg hidden-md hidden-sm " >
        <div class="row">
            <?=TopMenu::widget(['mobile'=>true])?>
            <div class="search-cont  search-cont-mobile">
                <input type="text" placeholder="Search">
                <i class="glyphicon glyphicon-search"></i>
            </div>  
        </div>
    </div>
    <div class="container-fluid hidden-xs">
        <div class="row">
            <div class="top-menu-cont  ">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 ">                        
                            <?=TopMenu::widget()?>
                            <div class="search-cont pull-right">
                                <input type="text" placeholder="Search">
                                <i class="glyphicon glyphicon-search"></i>
                            </div>  
                        </div>                              
                    </div>          
                </div>
            </div>
        </div>
    </div>  
                    
                        <?= $content ?>
     
    <div class="container-fluid footer-fluid">
        <div class="row">
            <div class="container footer">
                <div class="row ">
                    <div class="col-sm-12">
                        <div class="row  f-info hidden-sm hidden-xs">
                            <div class="col-md-6 ">
                                <div class="row">
                                    <div class="col-sm-12 ">
                                        <p class="f-title">E-SHOP</p>
                                    </div>  
                                    <div class="col-sm-4 ">
                                        <p class="f-menu-title">Service</p>
                                        <p><a href="#">Online Help</a></p>
                                        <p><a href="#">Contact Us</a></p>
                                        <p><a href="#">Order Status</a></p>
                                        <p><a href="#">FAQ’s</a></p>
                                    </div>
                                    <div class="col-sm-4 "> 
                                        <p class="f-menu-title">Quock Shop</p>
                                        <p><a href="#">For Men</a></p>
                                        <p><a href="#">For Women</a></p>
                                        <p><a href="#">For Chilldren</a></p>

                                    </div>
                                    <div class="col-sm-4 "> 
                                        <p class="f-menu-title">About US</p>
                                        <p><a href="#">Company Information</a></p>
                                        <p><a href="#">Store Location</a></p>
                                        <p><a href="#">Careers</a></p>
                                        <p><a href="#"></a></p>
                                    </div>  
                                </div>  
                            </div>  
                            <div class="col-md-6">
                                <div class="row inst-cont ">
                                    <div class="col-sm-12 ">
                                        <p class="f-title">INSTAGRAM FEED</p>
                                    </div>  
                                    <div class="col-sm-12 ">
                                    <img src="site_photos/inst1.jpg" class="img-responsive" alt="Responsive image">
                                    <img src="site_photos/inst2.jpg" class="img-responsive" alt="Responsive image">
                                    <img src="site_photos/inst3.jpg" class="img-responsive" alt="Responsive image">
                                    <img src="site_photos/inst4.jpg" class="img-responsive" alt="Responsive image">
                                    <img class="hidden-md" src="site_photos/inst5.jpg" class="img-responsive" alt="Responsive image">
                                    <div style="clear:both"></div>              
                                    <img src="site_photos/inst4.jpg" class="img-responsive" alt="Responsive image">             
                                    <img src="site_photos/inst5.jpg" class="img-responsive" alt="Responsive image">
                                    <img src="site_photos/inst1.jpg" class="img-responsive" alt="Responsive image">
                                    <img src="site_photos/inst3.jpg" class="img-responsive" alt="Responsive image">
                                    <img class="hidden-md" src="site_photos/inst2.jpg" class="img-responsive" alt="Responsive image">
                                    </div>
                                </div>
                            </div>                                                  
                        </div>  
                        <div class="row  f-info hidden-lg hidden-md" style="text-align:center">
                            <div class="col-md-6 " >
                                <div class="row" >
                                    <div class="col-sm-12 ">
                                        <p class="f-title">E-SHOP</p>
                                    </div>  
                                    <div class="col-sm-4 ">
                                        <p class="f-menu-title">Service</p>
                                        <p><a href="#">Online Help</a></p>
                                        <p><a href="#">Contact Us</a></p>
                                        <p><a href="#">Order Status</a></p>
                                        <p><a href="#">FAQ’s</a></p>
                                    </div>
                                    <div class="col-sm-4 "> 
                                        <p class="f-menu-title">Quock Shop</p>
                                        <p><a href="#">For Men</a></p>
                                        <p><a href="#">For Women</a></p>
                                        <p><a href="#">For Chilldren</a></p>

                                    </div>
                                    <div class="col-sm-4 "> 
                                        <p class="f-menu-title">About US</p>
                                        <p><a href="#">Company Information</a></p>
                                        <p><a href="#">Store Location</a></p>
                                        <p><a href="#">Careers</a></p>
                                        <p><a href="#"></a></p>
                                    </div>  
                                </div>  
                            </div>  <br>
                            <div class="col-md-6">
                                <div class="row inst-cont ">
                                    <div class="col-xs-12 ">
                                        <p class="f-title">INSTAGRAM FEED</p>
                                    </div>  
                                    <div class="col-xs-12 ">
                                        <div class="center-block hidden-xs" style="max-width:600px">
                                        <img src="site_photos/inst1.jpg" class="img-responsive" alt="Responsive image">
                                        <img src="site_photos/inst2.jpg" class="img-responsive" alt="Responsive image">
                                        <img src="site_photos/inst3.jpg" class="img-responsive" alt="Responsive image">
                                        <img src="site_photos/inst4.jpg" class="img-responsive" alt="Responsive image">            
                                        <img src="site_photos/inst4.jpg" class="img-responsive" alt="Responsive image">             
                                        <img src="site_photos/inst5.jpg" class="img-responsive" alt="Responsive image">
                                        </div>

                                        <div class="center-block hidden-sm" style="max-width:200px">
                                        <img src="site_photos/inst1.jpg" class="img-responsive" alt="Responsive image">
                                        <img src="site_photos/inst2.jpg" class="img-responsive" alt="Responsive image">
                                        <img src="site_photos/inst3.jpg" class="img-responsive" alt="Responsive image">
                                        <img src="site_photos/inst4.jpg" class="img-responsive" alt="Responsive image">            
                                        <img src="site_photos/inst4.jpg" class="img-responsive" alt="Responsive image">             
                                        <img src="site_photos/inst5.jpg" class="img-responsive" alt="Responsive image">
                                        </div>                                        
                                    </div>                        
                                </div>
                            </div>                                                  
                        </div>                                  
                    </div>              
                    <div class="col-sm-1"></div>
                    <!-- <div class="col-sm-10">
                        <div class="row inst-cont ">
                            <div class="col-sm-1 "></div>
                            <div class="col-sm-2 col-xs-6"><img src="site_photos/inst1.jpg" class="img-responsive" alt="Responsive image"></div>
                            <div class="col-sm-2 col-xs-6"><img src="site_photos/inst2.jpg" class="img-responsive" alt="Responsive image"></div>
                            <div class="col-sm-2 col-xs-6"><img src="site_photos/inst3.jpg" class="img-responsive" alt="Responsive image"></div>
                            <div class="col-sm-2 col-xs-6"><img src="site_photos/inst4.jpg" class="img-responsive" alt="Responsive image"></div>
                            <div class="col-sm-2 hidden-xs"><img src="site_photos/inst5.jpg" class="img-responsive" alt="Responsive image"></div>
                            <div class="col-sm-1 "></div>
                            
                        </div>
                    </div> -->
                    <div class="col-sm-1"></div>
                </div>
                <div class="footer-footer"></div>
            </div>
        </div>
        
    </div>
<?php $this->endBody() ?>   
</body>
</html>
<?php $this->endPage() ?>