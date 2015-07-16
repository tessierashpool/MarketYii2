<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\Order;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'Admin panel',
                'brandUrl' => ['/admin'],
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'encodeLabels'=>false,
                'items' => [
                    ['label' => 'Public side', 'url' => ['/site/index']],
                    ['label' => 'Users', 'url' => ['/admin/user']],
                    ['label' => 'Roles & Permissions', 'url' => ['/admin/auth-item']],
                    ['label' => 'Items', 'items' => [
                        ['label' => 'Categories(tree)', 'url' => ['/admin/categories/index']],
                        ['label' => 'Categories(gridview)', 'url' => ['/admin/categories/gridview']],
                        ['label' => 'Items', 'url' => ['/admin/items/index']],
                        //['label' => 'Parameters', 'url' => ['/admin/param-names']],
                    ]],                    
                    ['label' => 'Settings', 'items' => [
                        ['label' => 'Parameters categories', 'url' => ['/admin/param-categor']],
                        ['label' => 'Parameters', 'url' => ['/admin/param-names']],
                        ['label' => 'Delivery services', 'url' => ['/admin/delivery']],
                    ]],
                    ['label' => 'Orders <span id="order_light" class="badge"></span>', 'url' => ['/admin/order']],
                    Yii::$app->user->isGuest ?
                        ['label' => 'Login', 'url' => ['/site/login']] :
                        ['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                            'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']],
                ],
            ]);
            NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'homeLink' => [ 
                    'label' => Yii::t('yii', 'Home'),
                    'url' => ['/admin'],
                ],                
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; Admin panel <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
<script>
    function newOrdersAjax(){
        $.ajax({
            url: '<?=Url::to(['/admin/order/ajax-new-orders']);?>',
/*            error:function(data){
                $('.modal-errtot-text').text('Can\'t change item quantity');
                console.log(data);
                $('#errorModal').modal();
            },*/
            success:function(data){
                $('#order_light').text(data.count);
            }                
        });        
    }
    newOrdersAjax();
    setInterval(newOrdersAjax, 5000);
</script>
</body>
</html>
<?php $this->endPage() ?>
