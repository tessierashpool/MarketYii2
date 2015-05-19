<?php
namespace app\widgets\gridAllButton;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use Yii;

class GridAllButton extends Widget{
	public $link = '';
	public $attributName = 'ids';
	public $gridId = 'grid';
	public $buttonText = '<span class="glyphicon glyphicon-trash"></span> Delete Selected';
	public $confirMsg = 'Are you sure you want to delete all selected items?';
	
	public function init(){
		parent::init();
		if($this->link=='')
			$this->link = Url::to(["delete-all"]);
		$this->registerAssets();
	}
	
	public function run(){
	    echo '<p>';
	        echo '<button class="btn btn-success" type="submit" onclick="deleteAll(\''.$this->confirMsg.'\')">'.$this->buttonText.'</button>';
	    echo '</p>';
	}


    public function registerAssets()
    {
        $view = $this->getView();
        $link = $this->link;
        $csrfParam = Yii::$app->request->csrfParam;
        $csrfToken = Yii::$app->request->csrfToken;
        $registerFunction = <<< JS
function deleteAll(confirm_msg)
{
    var keys = $('#{$this->gridId}').yiiGridView('getSelectedRows');
    if(keys.length>0)
    {
        if(confirm(confirm_msg))
            $.form('{$link}', {{$this->attributName}: keys,{$csrfParam}:'{$csrfToken}'}, 'POST').submit();
    }        
}
JS;
		$view->registerJs($registerFunction,yii\web\View::POS_BEGIN);
        GridAllButtonAsset::register($view);
    }	
}
?>
