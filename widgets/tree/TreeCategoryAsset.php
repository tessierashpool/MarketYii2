<?php

namespace app\widgets\tree;

use yii\web\AssetBundle;
/**
 * TreeCategoryAsset 
 *
 */
class TreeCategoryAsset extends AssetBundle
{
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];

    /**
     * @inheritdoc
     */
    public $sourcePath = '@app/widgets/tree/assets/';
    public $css = ['css/categorytree.css'];
    public $js = ['js/categorytree.js'];
 
}