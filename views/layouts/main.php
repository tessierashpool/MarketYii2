<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\widgets\topMenu\TopMenu;
use app\assets\MarketAsset;
use yii\helpers\Url;
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
            <div class="col-sm-6">  
                <a href="<?=Yii::$app->homeUrl?>">           
                <div class="logo pull-left"></div>
                <p class="shop-name pull-left"><span style="color:#FF9933">E</span>-SHOP</p>    
                </a>             
            </div>
            <div class="col-sm-6">              
                <p class="pull-right header-menu"> 
                    <a href="#"><i class="glyphicon glyphicon-star"></i> Whishlist</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="<?=Url::to(['cart']);?>"><i class="glyphicon glyphicon-shopping-cart"></i> Cart</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?if(Yii::$app->user->isGuest):?>
                        <a href="<?=Url::to(['login']);?>"><i class="glyphicon glyphicon-lock"></i> Login</a>
                    <?else:?>
                        <a  href="#"><i class="glyphicon glyphicon-user"></i> Account</a>
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
            <nav style="margin-bottom:-1px" class="navbar navbar-default" role="navigation">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed pull-right" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand mobile-header" href="#">
                    <div class="logo pull-left"></div>                  
                    <span class="pull-right shop-name"><span style="color:#FF9933">E</span>-SHOP</span>
                  </a>
  
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">             
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">For Man <span class="caret"></span></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Shoes</a></li>
                            <li><a href="#">T-Shirts</a></li>
                            <li><a href="#">Jeans</a></li>
                          </ul>
                        </li>   
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">For Women <span class="caret"></span></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Shoes</a></li>
                            <li><a href="#">T-Shirts</a></li>
                            <li><a href="#">Jeans</a></li>
                          </ul>
                        </li>   
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">For Chilldren <span class="caret"></span></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Shoes</a></li>
                            <li><a href="#">T-Shirts</a></li>
                            <li><a href="#">Jeans</a></li>
                          </ul>
                        </li>                                               
                    </ul>       
                    <ul class="nav navbar-nav">
                        <li><a href="#"><i class="glyphicon glyphicon-star"></i> Whishlist</a></li>
                        <li><a href="<?=Url::to(['cart']);?>"><i class="glyphicon glyphicon-shopping-cart"></i> Cart</a></li>
                        <li>
                            <?if(Yii::$app->user->isGuest):?>
                            <a href="<?=Url::to(['login']);?>"><i class="glyphicon glyphicon-lock"></i> Login</a>
                            <?else:?>
                            <a href="<?=Url::to(['logout']);?>"><i class="glyphicon glyphicon-log-out"></i> Logout</a>
                            <?endif;?>

                        </li>                                             
                    </ul>                                       
                </div>          
            </nav>
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
     
    <div class="container-fluid footer">
        <div class="row">
            <div class="container">
                <div class="row ">
                    <div class="col-sm-12">
                        <div class="row  f-info hidden-xs">
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
                                    <div class="col-sm-4 col-xs-6"><img src="site_photos/inst1.jpg" class="img-responsive" alt="Responsive image"></div>
                                    <div class="col-sm-4 col-xs-6"><img src="site_photos/inst2.jpg" class="img-responsive" alt="Responsive image"></div>
                                    <div class="col-sm-4 col-xs-6"><img src="site_photos/inst3.jpg" class="img-responsive" alt="Responsive image"></div>                                
                                </div>
                            </div>                                                  
                        </div>  
                        <div class="row  f-info hidden-lg hidden-md hidden-sm" style="text-align:center">
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
                                    <div class="col-sm-12 ">
                                        <p class="f-title">INSTAGRAM FEED</p>
                                    </div>  
                                    <div class="col-xs-3"></div>                            
                                    <div class="col-xs-6"><img src="site_photos/inst1.jpg" class="img-responsive" alt="Responsive image"></div>                         
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
            </div>
        </div>
        <div class="footer-footer"></div>
    </div>
<?php $this->endBody() ?>   
</body>
</html>
<?php $this->endPage() ?>