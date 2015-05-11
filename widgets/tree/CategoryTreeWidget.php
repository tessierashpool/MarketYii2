<?php
namespace app\widgets\tree;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use Yii;

class CategoryTreeWidget extends Widget{
	public $category;
	
	public function init(){
		parent::init();
		if($this->category===null){
			$this->category = [];
		}
		$this->registerAssets();
	}
	
	public function run(){
	    echo '<hr>';
	    echo '<p><span onclick="openAllFolders()" class="folder menu-button"><i class="glyphicon glyphicon-folder-open foldeer-icon-open"></i>&nbsp; Open all folders</span>'.
	         '&nbsp;<span onclick="closeAllFolders()" class="folder menu-button"><i class="glyphicon glyphicon-folder-close foldeer-icon-close"></i>&nbsp;Close all folders</span></p>';
	    echo '<hr>';
	    echo '<div id="ultest">';
	    echo '<ul style="padding-left: 0;">';
	    echo $this->treeGenerator($this->category);
	    echo '</ul>';
	    echo '</div>';
	}

	public function treeGenerator($arCat = [], $parent_id=0, $debth=0)
	{       
	    foreach($arCat as $key=> $cat)
	    {
	        if(($cat['parent_id']==null&&$debth==null)||$parent_id == $cat['parent_id'])
	        {
	            $id = $cat['id'];           
	            echo '<li class="folder-li folder-li-'.$cat['id'].'" data-folder-id="'.$cat['id'].'">';            
	                echo '<input class="folder-input" type="checkbox" id="subfolder_'.$cat['id'].'"/>';
	                echo '<div class="folder">';
	                    echo '<label for="subfolder_'.$cat['id'].'">';
	                        echo '<i class="glyphicon glyphicon-folder-close foldeer-icon-close"></i>';
	                        echo '<i class="glyphicon glyphicon-folder-open foldeer-icon-open"></i>';
	                        echo '&nbsp; '.$cat['name'];
	                    echo '</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	                    echo '<span class="actions">';
	                        echo '<a href="'.Url::to(['view', 'id' => $cat['id']]).'"><i class="glyphicon glyphicon-eye-open"></i></a>';
	                        echo ' <a href="'.Url::to(['update', 'id' => $cat['id']]).'"><i class="glyphicon glyphicon-pencil"></i></a>';
	                        //echo ' <a href="'.Url::to(['delete', 'id' => $cat['id']]).'"><i class="glyphicon glyphicon-trash"></i></a>';
	                        echo ' '.Html::a('<i class="glyphicon glyphicon-trash"></i>', ['delete', 'id' => $cat['id']], [
	                                            'title' => Yii::t('yii', 'Delete'),
	                                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
	                                            'data-method' => 'post',
	                                            'data-pjax' => '0',
	                                        ]);
	                        echo ' <a href="javascript:void(0)" onclick="folderOrderUp('.$cat['id'].', \''.Url::to(['ajax-order-change']).'\')"><i class="glyphicon glyphicon-arrow-up"></i></a>';                        
	                        echo ' <a href="javascript:void(0)" onclick="folderOrderDown('.$cat['id'].', \''.Url::to(['ajax-order-change']).'\')"><i class="glyphicon glyphicon-arrow-down"></i></a>';                        

	                    echo '</span>';
	                echo '</div>';
	                       
	                echo '<ul>';
	                    unset($arCat[$key]);
	                    $arCat = $this->treeGenerator($arCat, $id, $debth + 1);
	                    echo '<li> <a href="'.Url::to(['create', 'parent' => $cat['id'], 'depth'=>$cat['depth']+1]).'" class="folder folder-create"><i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create subcategory').'</a></li>';
	                echo '</ul>';                       
	            echo '</li>';      
	        }
	    }
	    if(count($arCat)>0)
	        return $arCat;
	}

    public function registerAssets()
    {
        $view = $this->getView();
        TreeCategoryAsset::register($view);
    }	
}
?>
