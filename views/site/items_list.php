<?
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\models\Cart;
use app\models\Whishlist;

$this->registerJs("
$(function () {
  $('[data-toggle=\'tooltip\']').tooltip()
})
    ",\yii\web\View::POS_BEGIN);

//Yii::$app->response->cookies->remove('cart',true);
$cookies = Yii::$app->request->cookies;

$items = $dataProvider->getModels();
$whishlist = Whishlist::getWhishlist();
?>
<div class="row main-content">
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
                $(e).parent().addClass('active');  
                $(e).attr('onclick','removeFromWhishlist('+id+',this)');    
                whishlist(id,'add');
            }
        } 

        function removeFromWhishlist(id,e){
            if(!whishlistLock)
            {       
                whishlistLock = true;   
                $(e).parent().removeClass('active');  
                $(e).attr('onclick','addToWhishlist('+id+',this)'); 
                whishlist(id,'remove');
            }   
        }  

        /******************************
         * Add to cart functions
         ******************************/        
        var addToCartLock = false;
        function addItemToCart(id){
            if(!addToCartLock)
            {
                addToCartLock = true;
                ajaxGetSize(id);  
            }         
        }

        function addToCart(id,scode,sname){
            addToCartLock = true;
            $('#sizeSelectModal').modal('hide');
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
                    $('.added-img').attr('src',$('#item-'+id+' .img-responsive').attr('src'));
                    $('.added-title').html($('#item-'+id+' .i-title').html());
                    $('.added-size').text(data.sname);
                    $('.added-quantity').text(data.quantity);
                    $('.added-price').text($('#item-'+id+' .i-price').text());
                    $('.cart-light').html('<span>'+data.totalcount+'</span>');
                    $('#addToCartModal').modal();
                    addToCartLock = false;
                }                
            });          
        }

        function ajaxGetSize(id){           
            $.ajax({
                url: '<?=Url::to(['ajax-get-size']);?>',
                data: {id: id},
                error:function(data){
                    $('.modal-errtot-text').text('Can\'t get item size list');
                    $('#errorModal').modal();
                    addToCartLock = false;
                },
                success:function(data){
                    console.log(data.xl);
                    var strRadioList = '';
                    strRadioList += '<div  class="btn-group m-i-size"  data-toggle="buttons">';
                    
                    forEach(data,function(i, item) {
                        strRadioList+= '<label onclick="addToCart('+id+',\''+item.code+'\',\''+item.value+'\')" class="btn btn-default btn-sm ">';
                        strRadioList+= '<input type="radio" name="options" id="option1" autocomplete="off" > '+item.value;
                        strRadioList+= '</label>';
                    });
                    strRadioList += '</div>';
                    $('.modal-body-size').html(strRadioList);
                    sizeSelectModal();
                    addToCartLock = false;
                }                
            });          
        }

        function forEach(data, callback){
          for(var key in data){
            if(data.hasOwnProperty(key)){
              callback(key, data[key]);
            }
          }
        }

        function sizeSelectModal(){
            $('#sizeSelectModal').modal();
            $('.m-i-size').css({'width':$('.m-i-size').width()+1,'height':$('.m-i-size').height(),'display':'block','margin': '0 auto'});
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
<div id="sizeSelectModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="sizeModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title cart-modal-title">Select size</h4>
            </div>
            <div class="modal-body modal-body-size">
            </div>     
        </div>
    </div>
</div>    
    <?foreach ($items as $key => $model):?>
        <div class="col-sm-4">
            <div class="item-cont" id="item-<?=$model->id;?>">
                <div class="item-cont-inner-border"></div>
                <a class="img-cont" href="<?=Url::to(['detail', 'id' => $model->id]);?>">
                <img src="<?=$model->getImage()->getUrl('260x')?>" class="img-responsive">
                </a>
                <p class="i-price"><?=$model->price?> р</p>
                <p class="i-title"><a href="<?=Url::to(['detail', 'id' => $model->id]);?>"><?=$model->name.$model->id?></a></p>
                <div onclick="addItemToCart(<?=$model->id?>)" class="i-add-cart-link" >Add to cart <i class="glyphicon glyphicon-shopping-cart"></i></div>
                <?if($model->status=='new'):?>
                    <div class="ribbon-cont">
                        <div class="corner-ribbon top-right sticky green">NEW</div>
                    </div>        
                <?elseif($model->status=='top'):?>
                    <div class="ribbon-cont">
                        <div class="corner-ribbon top-right sticky orange">TOP</div>
                    </div>                           
                <?endif?>
<!--                 <div class="ribbon-cont">
<div class="corner-ribbon top-right sticky red">NEW</div>
</div> -->
<div class="add-to-wishlist-cont <?=in_array($model->id,$whishlist)?'active':'';?>">
    <a  onclick="<?=in_array($model->id,$whishlist)?'removeFromWhishlist':'addToWhishlist';?>(<?=$model->id?>,this)" href="javascript:void(0)"><i class="glyphicon glyphicon-heart"></i></a>
</div> 
            </div>
        </div>
    <?endforeach;?>

    <div class="nav-cont text-center">
<?=LinkPager::widget(['pagination' => $dataProvider->pagination,'maxButtonCount'=>6]);?>                             
    </div>              
</div>