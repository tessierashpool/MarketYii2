<?php
use app\models\Whishlist;
use app\models\Categories;
use yii\helpers\Url;
/* @var $this yii\web\View */
$this->registerJsFile(Yii::$app->request->baseUrl."/marketAssetsFiles/zoomer/zoomsl-3.0.modified.js",['depends' => ['app\assets\MarketAsset'], 'position'=>\yii\web\View::POS_HEAD]);
$this->registerJsFile(Yii::$app->request->baseUrl."/marketAssetsFiles/swipebox-master/src/js/jquery.swipebox.js",['depends' => ['app\assets\MarketAsset'],'position'=>\yii\web\View::POS_HEAD]);
$this->registerCssFile(Yii::$app->request->baseUrl."/marketAssetsFiles/swipebox-master/src/css/swipebox.css",['depends' => ['app\assets\MarketAsset']]);
$this->registerJs("
$(function () {
  $('[data-toggle=\'tooltip\']').tooltip()
})
    ",\yii\web\View::POS_BEGIN);
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
$whishlist = Whishlist::getWhishlist();
?>
<script>   
    /******************************
     * Add to whishlist functions
     ******************************/
    var whishlistLock = false;
    function whishlist(id,action){        
            if(action=='add')
                var url = '<?=Url::to(['ajax-add-to-whishlist']);?>';
            else
                var url = '<?=Url::to(['ajax-remove-from-whishlist']);?>';              
            $.ajax({
                url: url,
                data: {id: id,action:action},/*, _csrf :csrfToken*/
                error:function(data){
                    if(action=='add')
                        $('.modal-errtot-text').text('Can\'t add item to whishlist');
                    else
                        $('.modal-errtot-text').text('Can\'t remove item from whishlist');
                    console.log(data);
                    $('#errorModal').modal();
                    whishlistLock = false;
                },
                success:function(data){
                    whishlistLock = false;
                    var count = data.count;
                    if(action=='add')
                    {
                        if(count>0)
                            $('.whishlist-light').html('<span>'+count+'</span>');
                    }
                    else
                    {
                        if(count>0)
                            $('.whishlist-light').html('<span>'+count+'</span>');
                        else
                            $('.whishlist-light').html('');                   
                    }
                }                                  
            });       
    } 

    function addToWhishlist(id,e){
        if(!whishlistLock)
        {         
            whishlistLock = true; 
            $(e).addClass('active');  
            $(e).attr('onclick','removeFromWhishlist('+id+',this)');    
            whishlist(id,'add');
        }
    } 

    function removeFromWhishlist(id,e){
        if(!whishlistLock)
        {       
            whishlistLock = true;   
            $(e).removeClass('active');  
            $(e).attr('onclick','addToWhishlist('+id+',this)'); 
            whishlist(id,'remove');
        }   
    } 
    /******************************
     * Add to cart functions
     ******************************/
    var addToCartLock = false;
    function addItemToCart(id){
        var scode = $('.item-size.active').children('input').val();
        var sname = $('.item-size.active').text();
        if(!addToCartLock)
        {
            addToCartLock = true;
            addToCart(id,scode,sname);  
        }        
    }

    function addToCart(id,scode,sname){
        $.ajax({
            url: '<?=Url::to(['ajax-add-to-cart']);?>',
            data: {id: id,scode:scode,sname:sname},/*, _csrf :csrfToken*/
            error:function(data){
                $('.modal-errtot-text').text('Can\'t add item to cart');
                console.log(data);
                $('#errorModal').modal();
                addToCartLock = false;
            },
            success:function(data){
                $('.added-img').attr('src',$('img[data-swipe=1]').attr('src'));
                $('.added-title').text($('h2').text());
                $('.added-size').text(data.sname);
                $('.added-quantity').text(data.quantity);
                $('.added-price').text($('.d-price').text());
                $('.cart-light').html('<span>'+data.totalcount+'</span>');
                $('#addToCartModal').modal();
                addToCartLock = false;
            }                
        });          
    }

    //Modal vertical centering
    $(function() {
     
        function reposition() {
     
            var modal = $(this),
                dialog = modal.find('.modal-dialog');
     
            modal.css('display', 'block');
            
            // Dividing by two centers the modal exactly, but dividing by three 
            // or four works better for larger screens.
            dialog.css("margin-top", Math.max(0, ($(window).height() - dialog.height()) / 2));
     
        }
     
        // Reposition when a modal is shown
        $('.modal').on('show.bs.modal', reposition);
     
        // Reposition when the window is resized
        $(window).on('resize', function() {
            $('.modal:visible').each(reposition);
        });
     
    });

</script>
<div id="errorModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="sizeModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-danger" ><i class="glyphicon glyphicon-warning-sign"></i> Error</h4>
            </div>
            <div class="modal-body ">
                <p class="modal-errtot-text"></p>
            </div>     
        </div>
    </div>
</div> 
<div id="addToCartModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="sizeModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title cart-modal-title" >Item successfully added to your cart</h3>
            </div>            
            <div class="modal-body modal-body-added-cart">
                <div class="row">
                    <div class="col-xs-5">
                        <img  src="http://markett.com/index.php?r=yii2images%2Fimages%2Fimage-by-item-and-alias&item=Items1&dirtyAlias=cb0c9b390d-1_260x.jpg" class="img-responsive added-img" alt="Responsive image">
                    </div>  
                    <div>                     
                        <p><span class="added-title"><a href="#">Simple Print T-Shirt</a></span></p>
                        <p>Size: <span class="added-size">M</span></p>
                        <p>Quantity:<span class="added-quantity">1</span></p>
                        <p>Price:<span class="added-price">1500р</span></p> 
                    </div>                                          
                </div>  
            </div>     
        </div>
    </div>
</div>
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
                                        echo '<label class="btn btn-default btn-sm item-size active">';
                                    else
                                        echo '<label class="btn btn-default item-size btn-sm">';
                                    echo '<input type="radio" name="'.$value['code'].'" value="'.$listValue['code'].'" id="option3" autocomplete="off"> '.$listValue['value'];
                                    echo '</label>';
                                    $count++;
                                }
                            }
                    }
                    ?>
                </div>      
                <div style="clear:both"></div>              
                <div onclick="addItemToCart(<?=$model->id?>)" class="i-add-cart-link pull-left">Add to cart <i class="glyphicon glyphicon-shopping-cart"></i></div>
                <div data-toggle="tooltip" data-placement="top" title="Add to whishlist" onclick="<?=in_array($model->id,$whishlist)?'removeFromWhishlist':'addToWhishlist';?>(<?=$model->id?>,this)" class="i-add-whish-link pull-left <?=in_array($model->id,$whishlist)?'active':'';?>"><i class="glyphicon glyphicon-heart"></i></div>
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