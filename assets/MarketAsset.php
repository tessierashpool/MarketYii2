<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class MarketAsset extends AssetBundle
{
    public $basePath = '@webroot/marketAssetsFiles';
    public $baseUrl = '@web/marketAssetsFiles';
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $css = [
        'http://fonts.googleapis.com/css?family=Roboto:400,300&subset=latin,cyrillic-ext',
        'bootstrap/css/bootstrap.min.css',
        'bootstrap/css/bootstrap-theme.min.css',
        'font-awesome/css/font-awesome.min.css',
        'css/styless.css'
    ];
    public $js = [
        'jquery/jquery-1.11.2.min.js',
        'bootstrap/js/bootstrap.min.js',
        'jssor/js/jssor.slider.min.js',
        'nstSlider/jquery.nstSlider.min.js',
        'js/main.js'
    ];
     public $depends = [
        'yii\web\YiiAsset',
    ];   
}
