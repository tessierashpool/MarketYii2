<?php
use app\models\Categories;
use yii\helpers\Url;
/* @var $this yii\web\View */
$this->registerJsFile(Yii::$app->request->baseUrl."/marketAssetsFiles/zoomer/zoomsl-3.0.modified.js",['depends' => ['app\assets\MarketAsset'], 'position'=>\yii\web\View::POS_HEAD]);
$this->registerJsFile(Yii::$app->request->baseUrl."/marketAssetsFiles/swipebox-master/src/js/jquery.swipebox.js",['depends' => ['app\assets\MarketAsset'],'position'=>\yii\web\View::POS_HEAD]);
$this->registerCssFile(Yii::$app->request->baseUrl."/marketAssetsFiles/swipebox-master/src/css/swipebox.css",['depends' => ['app\assets\MarketAsset']]);
$this->registerJs("
    jQuery(function(){
        //var contHeight =  $('.d-images-cont').height() +20;
        var contHeight =  455;
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

} )( jQuery );",\yii\web\View::POS_END);

$this->title = $model->name;
$arB = Categories::getBreadcrumbsArray(['id'=>$model->category_id]);
foreach($arB as $cat)
{
    $this->params['breadcrumbs'][] = ['label' => $cat['name'], 'url' => Url::to(['index', 'c' => $cat['code']])];
}
$this->params['breadcrumbs'][] = $this->title;
$images = $model->getImages();
$fullInfo = $model->fullInfo;
?>
                        <div class="row detail-content">
                            <div class="col-sm-4 d-images-cont ">

                                <div class="row">
                                     <div class="col-sm-12 ">
                                        <div class="detail-img">                                        
                                            <img onclick="trackerClick()"  src="<?=$images[0]->getUrl('260x')?>" data-swipe="1"  data-large="<?=$images[0]->getUrl()?>"   class="img-responsive my-foto-container" alt="Responsive image">
                                        </div>
                                    </div>     
                                    <?foreach ($images as $key => $image) {
                                        echo '<div class="col-sm-4 hidden-xs">';
                                            echo '<span   href="'.$image->getUrl().'" class="swipebox swipebox_'.($key+1).'" ></span>';
                                            echo '<img src="'.$image->getUrl('260x').'" data-swipe="'.($key+1).'" data-large="'.$image->getUrl().'" class="img-responsive my-foto" alt="Responsive image">';
                                        echo '</div>';
                                    }?>                             
                                                                       
<!--                                     <div class="col-sm-12 ">
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
</div> -->

                                </div>
                            </div>  
                            <div class="col-sm-8">  
                                <div class="row">
                                    <div class="col-sm-12 zoomer-cont">
                                        <h2><?=$model->name?>
                                        <!-- <p class="d-i-type"> T-Shirt </p> --></h2>
                                        <p class="d-price"> <?=$model->price?> р</p>
                                        <div class="btn-group d-i-size" data-toggle="buttons">
                                            <?
                                            foreach ($fullInfo['category_variants'] as $value) {
                                                if(count($value['listValues'])>0)
                                                    $count=1;
                                                    foreach ($value['listValues'] as $key => $listValue){
                                                        if(count($fullInfo['variants'][$value['id']][$listValue['code']])>0)
                                                        {
                                                            if($count==1)
                                                                echo '<label class="btn btn-default btn-sm active">';
                                                            else
                                                                echo '<label class="btn btn-default btn-sm">';
                                                            echo '<input type="radio" name="'.$value['code'].'" value="'.$listValue['code'].'" id="option3" autocomplete="off"> '.$listValue['value'];
                                                            echo '</label>';
                                                            $count++;
                                                        }
                                                    }
                                            }

                                            ?>
                                        </div>      
                                        <div style="clear:both"></div>              
                                        <div class="i-add-cart-link pull-left">Add to cart <i class="glyphicon glyphicon-shopping-cart"></i></div>
                                        <div class="i-add-whish-link pull-left"><i class="glyphicon glyphicon-heart"></i></div>
                                        <div style="clear:both"></div>
                                        <p class="d-description"><?=$model->description?></p>
                                        <table class="table">
                                            <?foreach ($fullInfo['category_parameters']  as $key => $value):?>
                                                 <tr>
                                                    <td width="40%"><?=$value['name']?></td>
                                                    <?
                                                    if($value['type']=='list')
                                                    {
                                                        foreach($value['listValues'] as $listValue)
                                                        {
                                                            if($listValue['code']==$fullInfo['parameters'][$value['id']])
                                                            {
                                                                echo '<td >'.$listValue['value'].'</td>';
                                                                break;
                                                            }
                                                        }
                                                    }
                                                    else
                                                    {
                                                        echo '<td >'.$fullInfo['parameters'][$value['id']].'</td>';
                                                    }
                                                    ?>
                                                    
                                                </tr>                                           
                                            <?endforeach;?>                                                                                                                                                                      
                                        </table>
                                    </div>                                                                                                  
                                </div>                              
                            </div>                                                      
                        </div>                