<?php
/* @var $this yii\web\View */
$this->title = 'My Yii Application';
$this->registerJsFile(Yii::$app->request->baseUrl."/marketAssetsFiles/zoomer/zoomsl-3.0.modified.js",['depends' => ['app\assets\MarketAsset'], 'position'=>\yii\web\View::POS_HEAD]);
$this->registerJsFile(Yii::$app->request->baseUrl."/marketAssetsFiles/swipebox-master/src/js/jquery.swipebox.js",['depends' => ['app\assets\MarketAsset'],'position'=>\yii\web\View::POS_HEAD]);
$this->registerCssFile(Yii::$app->request->baseUrl."/marketAssetsFiles/swipebox-master/src/css/swipebox.css",['depends' => ['app\assets\MarketAsset']]);
$this->registerJs("
    jQuery(function(){
        var contHeight =  $('.d-images-cont').height() +20;
        var contWidth = $('.zoomer-cont').width() +5;
        if($(document).width()>768)
        {
            $('.my-foto-container').imagezoomsl({disablewheel:false,magnifycursor:'pointer',cursorshade:false,zoomstart:3,rightoffset:28,magnifiersize:[contWidth ,contHeight] ,zindex:10000,magnifierspeedanimate:200,scrollspeedanimate:1,zoomspeedanimate:2,loopspeedanimate:1,magnifiereffectanimate:'fadeIn'});
        }   

        //клик по превью-картинке
        $('.my-foto').click(function(){
           var that = this;
            //копируем атрибуты из превью-картинки в контейнер-картинку
            $('.my-foto-container').fadeOut(100, function(){

            $(this).attr('src',              $(that).attr('src'))              // путь до small картинки
                .attr('data-large',       $(that).attr('data-large'))       // путь до big картинки
                
                //дополнительные атрибуты, если есть
                .attr('data-swipe',       $(that).attr('data-swipe'))                          
                .fadeIn(100);               
            });
        });   
    });  
    //Комбинация двух библиотек zoomsl и swipebox
    //Функция добавленая в zoomsl, вызывате  при клике на tracker div
    function trackerClick(){
        var swipe_num = $('.my-foto-container').attr('data-swipe');
        $('.swipebox_'+swipe_num).trigger( 'click' );
    }

( function( $ ) {

    $( '.swipebox' ).swipebox({loopAtEnd:true});

} )( jQuery );",\yii\web\View::POS_BEGIN);
?>
                        <div class="row detail-content">
                            <div class="col-sm-4 d-images-cont ">

                                <div class="row">
                                    <div class="col-sm-12 ">
                                        <div class="detail-img">                                        
                                            <img onclick="trackerClick()"  src="site_photos/mini_photo1.jpg" data-swipe="1"  data-large="site_photos/large_photo1.jpg"   class="img-responsive my-foto-container" alt="Responsive image">
                                        </div>
                                    </div>                                  
                                    <div class="col-sm-4 hidden-xs ">
                                        <span   href="site_photos/large_photo1.jpg"  class="swipebox swipebox_1" ></span>
                                        <img src="site_photos/mini_photo1.jpg" data-swipe="1"  data-large="site_photos/large_photo1.jpg" class="img-responsive my-foto" alt="Responsive image">
                                        
                                    </div>
                                    <div class="col-sm-4 hidden-xs">
                                        <span   href="site_photos/large_photo2.jpg" class="swipebox swipebox_2" ></span>
                                        <img src="site_photos/mini_photo2.jpg" data-swipe="2"  data-large="site_photos/large_photo2.jpg" class="img-responsive my-foto" alt="Responsive image">
                                    </div>
                                    <div class="col-sm-4 hidden-xs">
                                        <span   href="site_photos/large_photo3.jpg" class="swipebox swipebox_3" ></span>
                                        <img src="site_photos/mini_photo3.jpg" data-swipe="3" data-large="site_photos/large_photo3.jpg" class="img-responsive my-foto" alt="Responsive image">
                                    </div>

                                </div>
                            </div>  
                            <div class="col-sm-8">  
                                <div class="row">
                                    <div class="col-sm-12 zoomer-cont">
                                        <h2>Simple Print T-Shirt
                                        <p class="d-i-type"> T-Shirt </p></h2>
                                        <p class="d-price"> 4500 р</p>
                                        <div class="btn-group d-i-size" data-toggle="buttons">
                                            <label class="btn btn-default btn-sm active">
                                                <input type="radio" name="options" id="option1" autocomplete="off" checked> S
                                            </label>
                                            <label class="btn btn-default btn-sm">
                                                <input type="radio" name="options" id="option2" autocomplete="off"> M
                                            </label>
                                            <label class="btn btn-default btn-sm">
                                                <input type="radio" name="options" id="option3" autocomplete="off"> L
                                            </label>
                                        </div>      
                                        <div style="clear:both"></div>              
                                        <a class="i-add-cart-link pull-left" href="#">Add to cart <i class="glyphicon glyphicon-shopping-cart"></i></a>
                                        <a class="i-add-whish-link pull-left" href="#"><i class="glyphicon glyphicon-star"></i></a>
                                        <div style="clear:both"></div>
                                        <p class="d-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                        <table class="table">
                                            <tr>
                                                <td  width="40%">Материал верха</td>
                                                <td >искусственная кожа, искусственный нубук </td>
                                            </tr>
                                            <tr>
                                                <td  width="40%">Внутренний материал</td>
                                                <td >искусственный мех </td>
                                            </tr>
                                            <tr>
                                                <td  width="40%">Материал стельки</td>
                                                <td >текстиль</td>
                                            </tr>
                                            <tr>
                                                <td  width="40%">Материал подошвы</td>
                                                <td >резина</td>
                                            </tr>
                                            <tr>
                                                <td  width="40%">Цвет</td>
                                                <td >черный</td>
                                            </tr>
                                            <tr>
                                                <td  width="40%">Сезон</td>
                                                <td >Демисезон, Зима </td>
                                            </tr>                                                                                                                                                                       
                                        </table>
                                    </div>                                                                                                  
                                </div>                              
                            </div>                                                      
                        </div>                