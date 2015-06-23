<?php
use app\models\Items;
use yii\helpers\Url;
/* @var $this yii\web\View */
$this->title = 'My Yii Application';
$this->registerJs("
    function itemCartPlus(id,scode){
        var quantInp = $('.item-quanity-'+id+'-'+scode);
        var curQuant = parseInt(quantInp.val());
        var itemPrice = parseInt($('.item-price-'+id+'-'+scode).val());
        var totalPriceCont = $('.total-item-price-'+id+'-'+scode);
        var inputTotalPriceCont = $('.input-total-item-price-'+id+'-'+scode);
        curQuant = curQuant+1;
        quantInp.val(curQuant);
        totalPriceCont.text(itemPrice*curQuant);
        inputTotalPriceCont.val(itemPrice*curQuant);
        calculateTotalPrice();      
    }
    function itemCartMinus(id,scode){
        var quantInp = $('.item-quanity-'+id+'-'+scode);
        var curQuant = parseInt(quantInp.val());
        var itemPrice = parseInt($('.item-price-'+id+'-'+scode).val());
        var totalPriceCont = $('.total-item-price-'+id+'-'+scode);
        var inputTotalPriceCont = $('.input-total-item-price-'+id+'-'+scode);
        if(curQuant>1)
            curQuant = curQuant-1;
        quantInp.val(curQuant);
        totalPriceCont.text(itemPrice*curQuant);
        inputTotalPriceCont.val(itemPrice*curQuant);
        calculateTotalPrice();
    }   
    function calculateTotalPrice(){
        var sum = 0;
        $('.input-total-item-price').each(function(index){
            sum = sum + parseInt($(this).val());
        });
        $('.total-cart-price').text(sum);
    }
$(function () {
  $('[data-toggle=\'tooltip\']').tooltip()
})
    ",\yii\web\View::POS_BEGIN);

$this->title = "Cart";
$this->params['breadcrumbs'][] = $this->title;
$cart = \app\models\Cart::getCart();
?>
<script>
    function deleteItem(id,scode){
        $('.tr-item-'+id+'-'+scode).remove();
        calculateTotalPrice();
        $.ajax({
            url: '<?=Url::to(['ajax-delete-cart-item']);?>',
            data: {id: id,scode:scode},/*, _csrf :csrfToken*/
            error:function(data){
                $('.modal-errtot-text').text('Can\'t delete item from cart');
                console.log(data);
                $('#errorModal').modal();
            },
            success:function(data){
                console.log(data);
                if(parseInt(data.totalcount)>0)
                    $('.cart-light').html('<span>'+data.totalcount+'</span>');
                else
                {
                    $('.cart-light').html('');
                    $('.tr-cart-item, .cart-checkout-btn').remove();
                    $('.cart-content div table').append('<tr><td colspan="5">Your cart is empty</td></tr>');
                }
            }                
        });          
    }

    function deleteAllItems(){
        $('.tr-cart-item, .cart-checkout-btn').remove();
        $('.cart-content div table').append('<tr><td colspan="5">Your cart is empty</td></tr>');
        $.ajax({
            url: '<?=Url::to(['ajax-delete-cart-all-items']);?>',
            error:function(data){
                $('.modal-errtot-text').text('Can\'t delete items from cart');
                console.log(data);
                $('#errorModal').modal();
            },
            success:function(data){
                console.log(data);
                $('.cart-light').html('');
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
<div class="row cart-content">
    <div class="col-sm-12 hidden-xs">
        <h2 class="custom-h2"><?=$this->title?></h2>
        <table class="table">
            <tr>
                <td width="40%" style="position: relative;">
                    <div class="cart-cart-icon"><i class="glyphicon glyphicon-shopping-cart"></i></div>
                    ITEM
                </td>
                <td >PRICE</td>
                <td >QUANITY</td>
                <td >TOTAL</td>
                <td ></td>
            </tr>    
            <?if(count($cart)>0):?>         
                <?foreach ($cart as $key => $value):?>  
                    <?$item = Items::findOne($value['id'])?> 
                    <tr class="tr-cart-item tr-item-<?=$value['id']?>-<?=$value['scode']?>">
                        <td width="40%">
                            <div class="row">
                                <div class="col-xs-4">
                                    <img src="<?=$item->getImage()->getUrl('260x')?>" class="img-responsive cart-img" alt="Responsive image">
                                </div>
                                <div class="col-xs-8">
                                    <p><a href="<?=Url::to(['detail', 'id' => $item->id]);?>"><?=$item->name?></a></p>
                                    <p>Size: <?=$value['sname']?></p>
                                </div>                                              
                            </div>
                        </td>
                        <td >
                            <span class="item-price"><?=$item->price?></span>р
                            <input class="item-price-<?=$value['id']?>-<?=$value['scode']?>" type="hidden" value="<?=$item->price?>">
                        </td>
                        <td >
                            <div class="input-group">
                              <span class="input-group-btn">
                                <button class="btn btn-default btn-xs" onclick="itemCartMinus(<?=$value['id']?>,'<?=$value['scode']?>')" type="button"><i class="fa fa-minus"></i></button>
                              </span>
                              <input readonly ="true" autocomplete="off" type="text" class="form-control input-xs item-quanity-<?=$value['id']?>-<?=$value['scode']?>" value="<?=$value['quantity']?>">
                              <span class="input-group-btn">
                                <button class="btn btn-default btn-xs" onclick="itemCartPlus(<?=$value['id']?>,'<?=$value['scode']?>')" type="button"><i class="fa fa-plus"></i></button>
                              </span>                                             
                            </div>                                          
                        </td>
                        <td >
                            <span class="total-item-price total-item-price-<?=$value['id']?>-<?=$value['scode']?>"><?=$item->price*$value['quantity']?></span>р
                            <input class="input-total-item-price input-total-item-price-<?=$value['id']?>-<?=$value['scode']?>" type="hidden" value="<?=$item->price*$value['quantity']?>">
                        </td>
                        <td ><a data-toggle="tooltip" onclick="deleteItem(<?=$value['id']?>,'<?=$value['scode']?>')" data-placement="left" title="Delete Item"  href="javascript:void(0)"><i class="fa fa-trash-o"></i></a></td>
                    </tr>                                                   
                <?endforeach;?>                                         
                <tr class="tr-cart-item">
                    <td>TOTAL PRICE</td>
                    <td ></td>
                    <td ></td>
                    <td ><span class="total-cart-price">4500</span>р</td>
                    <td ><a data-toggle="tooltip" onclick="deleteAllItems()" data-placement="left" title="Delete All" href="javascript:void(0)"><i class="fa fa-trash-o"></i></a></td>
                </tr>
            <?else:?>  
                <tr>
                    <td colspan="5">Your cart is empty</td>
                </tr>                                                   
            <?endif;?>             
        </table>
        <?if(count($cart)>0):?>
            <a class="i-add-cart-link cart-checkout-btn" href="#">Checkout <i class="glyphicon glyphicon-chevron-right"></i></a>
        <?endif;?>  
    </div>  
    <!-- Mobile version --> 
    <div class="col-sm-12  hidden-lg hidden-md hidden-sm">
        <h2 class="custom-h2"><?=$this->title?></h2>
        <table class="table">
            <tr>
                <td style="position: relative;">
                    <div class="cart-cart-icon"><i class="glyphicon glyphicon-shopping-cart"></i></div>
                    Cart
                </td>
            </tr>  
            <?if(count($cart)>0):?>
                <?foreach ($cart as $key => $value):?>  
                    <?$item = Items::findOne($value['id'])?>
                    <tr class="tr-cart-item tr-item-<?=$value['id']?>-<?=$value['scode']?>" >
                        <td >
                            <div class="row">
                                <div class="col-xs-4">
                                    <img src="<?=$item->getImage()->getUrl('260x')?>" class="img-responsive cart-img" alt="Responsive image">
                                </div>
                                <div class="col-xs-8">
                                    <p><a href="<?=Url::to(['detail', 'id' => $item->id]);?>"><?=$item->name?></a></p>
                                    <p>Size:<?=$value['sname']?></p>
                                    <p><a onclick="deleteItem(<?=$value['id']?>,'<?=$value['scode']?>')" href="javascript:void(0)">Delete <i class="fa fa-trash-o"></i></a></p>
                                    <p>Price: <span class="item-price-cont"><span class="item-price"><?=$item->price?></span>p</span></p>
                                    <div class="input-group" style="width:100px;margin-bottom: 10px;">
                                      <span class="input-group-btn">
                                        <button class="btn btn-default btn-xs" onclick="itemCartMinus(<?=$value['id']?>,'<?=$value['scode']?>')" type="button"><i class="fa fa-minus"></i></button>
                                      </span>
                                      <input readonly ="true" autocomplete="off" type="text" class="form-control input-xs item-quanity-<?=$value['id']?>-<?=$value['scode']?>" value="<?=$value['quantity']?>">
                                      <span class="input-group-btn">
                                        <button class="btn btn-default btn-xs" onclick="itemCartPlus(<?=$value['id']?>,'<?=$value['scode']?>')" type="button"><i class="fa fa-plus"></i></button>
                                      </span>                                             
                                    </div>  
                                    <p>Total price: <span class="item-price-cont"><span class="total-item-price total-item-price-<?=$value['id']?>-<?=$value['scode']?>"><?=$item->price*$value['quantity']?></span>p</span></p>
                                </div>      
                            </div>
                        </td>
                    </tr>                 
                <?endforeach;?> 
                <tr class="tr-cart-item">
                    <td><a onclick="deleteAllItems()" href="javascript:void(0)">Delete All <i class="fa fa-trash-o"></i></a></td>
                </tr>                                                                             
                <tr class="tr-cart-item">
                    <td>TOTAL CART PRICE: <span class="item-price-cont"> <span class="total-cart-price">3500</span>p </span></td>
                </tr>
            <?else:?>  
                <tr>
                    <td >Your cart is empty</td>
                </tr>                                                   
            <?endif;?>             
        </table>
        <?if(count($cart)>0):?>
            <a class="i-add-cart-link cart-checkout-btn" href="#">Checkout <i class="glyphicon glyphicon-chevron-right"></i></a>
        <?endif;?>  
    </div>
    <script>calculateTotalPrice();</script>
    <!-- Mobile version end -->                                                 
</div>                      