<?php

namespace app\widgets\gridAllButton;

use yii\web\AssetBundle;
/**
 * TreeCategoryAsset 
 *
 */
class GridAllButtonAsset extends AssetBundle
{
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];

    /**
     * @inheritdoc
     */
    public $sourcePath = '@app/widgets/gridAllButton/assets/';
    public $js = ['js/gridAllButton.js'];
    public $depends = ['yii\web\JqueryAsset'];
 
}