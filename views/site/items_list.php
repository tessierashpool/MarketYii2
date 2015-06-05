<?
use yii\helpers\Url;
use yii\widgets\LinkPager;

$items = $dataProvider->getModels();
?>
<div class="row main-content">
    <?foreach ($items as $key => $model):?>
        <div class="col-sm-4">
            <div class="item-cont">
                <div class="item-cont-inner-border"></div>
                <a class="img-cont" href="#">
                <img src="<?=$model->getImage()->getUrl('300x')?>" class="img-responsive" alt="Responsive image">
                </a>
                <p class="i-price"><?=$model->price?> р</p>
                <p class="i-title"><a href="<?=Url::to(['detail', 'id' => $model->id]);?>"><?=$model->name?></a></p>
                <a class="i-add-cart-link" href="#">Add to cart <i class="glyphicon glyphicon-shopping-cart"></i></a>
<!--                 <div class="ribbon-cont">
<div class="corner-ribbon top-right sticky red">NEW</div>
</div> -->
<div class="add-to-wishlist-cont">
    <a title="Add to wishlist" href="#"><i class="glyphicon glyphicon-heart"></i></a>
</div> 
            </div>
        </div>
    <?endforeach;?>

    <div class="nav-cont text-center">
<?=LinkPager::widget(['pagination' => $dataProvider->pagination,'maxButtonCount'=>6]);?>                             
    </div>              
</div>