<?php
/* @var $this yii\web\View */
$this->title = 'My Yii Application';
$this->registerJs("
    function itemCartPlus(e){
        var quantInp = $(e).parent().parent().children('.item-quanity');
        var curQuant = parseInt(quantInp.val());
        var itemPrice = parseInt($(e).parent().parent().parent().prev('td').children('.item-price').text());
        var totalPriceCont = $(e).parent().parent().parent().next('td').children('.total-item-price');
        curQuant = curQuant+1;
        quantInp.val(curQuant);
        totalPriceCont.text(itemPrice*curQuant);
        calculateTotalPrice();      
    }
    function itemCartMinus(e){
        var quantInp = $(e).parent().parent().children('.item-quanity');
        var curQuant = parseInt(quantInp.val());
        var itemPrice = parseInt($(e).parent().parent().parent().prev('td').children('.item-price').text());
        var totalPriceCont = $(e).parent().parent().parent().next('td').children('.total-item-price');
        if(curQuant>1)
            curQuant = curQuant-1;
        quantInp.val(curQuant);
        totalPriceCont.text(itemPrice*curQuant);
        calculateTotalPrice();
    }   
    function calculateTotalPrice(){
        var sum = 0;
        $('.total-item-price').each(function(index){
            sum = sum + parseInt($(this).text());
        });
        $('.total-cart-price').text(sum);
    }",\yii\web\View::POS_BEGIN);
?>
                        <div class="row cart-content">
                            <div class="col-sm-12 hidden-xs">
                                <table class="table">
                                    <tr>
                                        <td width="40%">
                                            <div class="cart-cart-icon"><i class="glyphicon glyphicon-shopping-cart"></i></div>
                                            ITEM
                                        </td>
                                        <td >PRICE</td>
                                        <td >QUANITY</td>
                                        <td >TOTAL</td>
                                        <td ></td>
                                    </tr>                                       
                                    <tr>
                                        <td width="40%">
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <img src="site_photos/mini_photo1.jpg" class="img-responsive" alt="Responsive image">
                                                </div>
                                                <div class="col-xs-8">
                                                    <p>Simple Print T-Shirt</p>
                                                    <p>Size:M</p>
                                                    <p>Color:Black</p>
                                                    <p><a href="#">Edit <i class="fa fa-pencil"></i></a></p>
                                                </div>                                              
                                            </div>
                                        </td>
                                        <td ><span class="item-price">1500</span>р</td>
                                        <td >
                                            <div class="input-group">
                                              <span class="input-group-btn">
                                                <button class="btn btn-default btn-xs" onclick="itemCartMinus(this)" type="button"><i class="fa fa-minus"></i></button>
                                              </span>
                                              <input readonly ="true" autocomplete="off" type="text" class="form-control input-xs item-quanity" value="1">
                                              <span class="input-group-btn">
                                                <button class="btn btn-default btn-xs" onclick="itemCartPlus(this)" type="button"><i class="fa fa-plus"></i></button>
                                              </span>                                             
                                            </div>                                          

                                        </td>
                                        <td ><span class="total-item-price">1500</span>р</td>
                                        <td ><a href="#"><i class="fa fa-trash-o"></i></a></td>
                                    </tr>   
                                    <tr>
                                        <td width="40%">
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <img src="site_photos/mini_photo2.jpg" class="img-responsive" alt="Responsive image">
                                                </div>
                                                <div class="col-xs-8">
                                                    <p>Simple Print T-Shirt</p>
                                                    <p>Size:M</p>
                                                    <p>Color:Black</p>
                                                    <p><a href="#">Edit <i class="fa fa-pencil"></i></a></p>
                                                </div>                                              
                                            </div>
                                        </td>
                                        <td ><span class="item-price">1500</span>р</td>
                                        <td >
                                            <div class="input-group">
                                              <span class="input-group-btn">
                                                <button class="btn btn-default btn-xs" onclick="itemCartMinus(this)" type="button"><i class="fa fa-minus"></i></button>
                                              </span>
                                              <input readonly ="true" autocomplete="off" type="text" class="form-control input-xs item-quanity" value="1">
                                              <span class="input-group-btn">
                                                <button class="btn btn-default btn-xs" onclick="itemCartPlus(this)" type="button"><i class="fa fa-plus"></i></button>
                                              </span>                                             
                                            </div>                                          

                                        </td>
                                        <td ><span class="total-item-price">1500</span>р</td>
                                        <td ><a href="#"><i class="fa fa-trash-o"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td width="40%">
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <img src="site_photos/mini_photo3.jpg" class="img-responsive" alt="Responsive image">
                                                </div>
                                                <div class="col-xs-8">
                                                    <p>Simple Print T-Shirt</p>
                                                    <p>Size:M</p>
                                                    <p>Color:Black</p>
                                                    <p><a href="#">Edit <i class="fa fa-pencil"></i></a></p>
                                                </div>                                              
                                            </div>
                                        </td>
                                        <td ><span class="item-price">1500</span>р</td>
                                        <td >
                                            <div class="input-group">
                                              <span class="input-group-btn">
                                                <button class="btn btn-default btn-xs" onclick="itemCartMinus(this)" type="button"><i class="fa fa-minus"></i></button>
                                              </span>
                                              <input readonly ="true" autocomplete="off" type="text" class="form-control input-xs item-quanity" value="1">
                                              <span class="input-group-btn">
                                                <button class="btn btn-default btn-xs" onclick="itemCartPlus(this)" type="button"><i class="fa fa-plus"></i></button>
                                              </span>                                             
                                            </div>                                          

                                        </td>
                                        <td ><span class="total-item-price">1500</span>р</td>
                                        <td ><a href="#"><i class="fa fa-trash-o"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>TOTAL PRICE</td>
                                        <td ></td>
                                        <td ></td>
                                        <td ><span class="total-cart-price">4500</span>р</td>
                                        <td ></td>
                                    </tr>
                                </table>
                                <a class="i-add-cart-link" href="#">Checkout <i class="glyphicon glyphicon-chevron-right"></i></a>
                            </div>  
                            <!-- Mobile version --> 
                            <div class="col-sm-12  hidden-lg hidden-md hidden-sm">
                                <table class="table">
                                    <tr>
                                        <td >
                                            <div class="cart-cart-icon"><i class="glyphicon glyphicon-shopping-cart"></i></div>
                                            Cart
                                        </td>
                                    </tr>                                       
                                    <tr>
                                        <td >
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <img src="site_photos/mini_photo1.jpg" class="img-responsive" alt="Responsive image">
                                                </div>
                                                <div class="col-xs-8">
                                                    <p>Simple Print T-Shirt</p>
                                                    <p>Size:M</p>
                                                    <p>Color:Black</p>
                                                    <p><a href="#">Edit <i class="fa fa-pencil"></i></a></p>
                                                    <p><a href="#">Delete <i class="fa fa-trash-o"></i></a></p>
                                                    <p>Price: <span class="item-price-cont"><span class="item-price">1500</span>p</span></p>
                                                    <div class="input-group" style="width:100px;margin-bottom: 10px;">
                                                      <span class="input-group-btn">
                                                        <button class="btn btn-default btn-xs" onclick="itemCartMinus(this)" type="button"><i class="fa fa-minus"></i></button>
                                                      </span>
                                                      <input readonly ="true" autocomplete="off" type="text" class="form-control input-xs item-quanity" value="1">
                                                      <span class="input-group-btn">
                                                        <button class="btn btn-default btn-xs" onclick="itemCartPlus(this)" type="button"><i class="fa fa-plus"></i></button>
                                                      </span>                                             
                                                    </div>  
                                                    <p>Total price: <span class="item-price-cont">1500p</span></p>
                                                </div>      
                                            </div>
                                        </td>
                                    </tr>   
                                    <tr>
                                        <td >
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <img src="site_photos/mini_photo2.jpg" class="img-responsive" alt="Responsive image">
                                                </div>
                                                <div class="col-xs-8">
                                                    <p>Simple Print T-Shirt</p>
                                                    <p>Size:M</p>
                                                    <p>Color:Black</p>
                                                    <p><a href="#">Edit <i class="fa fa-pencil"></i></a></p>
                                                    <p><a href="#">Delete <i class="fa fa-trash-o"></i></a></p>
                                                    <p>Price: <span class="item-price-cont"><span class="item-price">1500</span>p</span></p>
                                                    <div class="input-group" style="width:100px;margin-bottom: 10px;">
                                                      <span class="input-group-btn">
                                                        <button class="btn btn-default btn-xs" onclick="itemCartMinus(this)" type="button"><i class="fa fa-minus"></i></button>
                                                      </span>
                                                      <input readonly ="true" autocomplete="off" type="text" class="form-control input-xs item-quanity" value="1">
                                                      <span class="input-group-btn">
                                                        <button class="btn btn-default btn-xs" onclick="itemCartPlus(this)" type="button"><i class="fa fa-plus"></i></button>
                                                      </span>                                             
                                                    </div>  
                                                    <p>Total price: <span class="item-price-cont">1500p</span></p>                                                  
                                                </div>                                              
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <img src="site_photos/mini_photo3.jpg" class="img-responsive" alt="Responsive image">
                                                </div>
                                                <div class="col-xs-8">
                                                    <p>Simple Print T-Shirt</p>
                                                    <p>Size:M</p>
                                                    <p>Color:Black</p>
                                                    <p><a href="#">Edit <i class="fa fa-pencil"></i></a></p>
                                                    <p><a href="#">Delete <i class="fa fa-trash-o"></i></a></p>
                                                    <p>Price: <span class="item-price-cont"><span class="item-price">1500</span>p</span></p>
                                                    <div class="input-group" style="width:100px;margin-bottom: 10px;">
                                                      <span class="input-group-btn">
                                                        <button class="btn btn-default btn-xs" onclick="itemCartMinus(this)" type="button"><i class="fa fa-minus"></i></button>
                                                      </span>
                                                      <input readonly ="true" autocomplete="off" type="text" class="form-control input-xs item-quanity" value="1">
                                                      <span class="input-group-btn">
                                                        <button class="btn btn-default btn-xs" onclick="itemCartPlus(this)" type="button"><i class="fa fa-plus"></i></button>
                                                      </span>                                             
                                                    </div>  
                                                    <p>Total price: <span class="item-price-cont">1500p</span></p>                                                  
                                                </div>                                              
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>TOTAL CART PRICE: <span class="item-price-cont"> 3500p </span></td>
                                    </tr>
                                </table>
                                <a class="i-add-cart-link" href="#">Checkout <i class="glyphicon glyphicon-chevron-right"></i></a>
                            </div>
                            <!-- Mobile version end -->                                                 
                        </div>                      