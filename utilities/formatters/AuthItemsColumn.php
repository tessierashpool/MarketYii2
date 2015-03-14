<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\utilities\formatters;

use Yii;
use yii\helpers\Html;
use yii\grid\DataColumn;

class AuthItemsColumn extends DataColumn
{
 
	public function init()
	{
		$this->content = [$this, 'makeAuthItemsContent'];
	}

	protected function makeAuthItemsContent($model)
	{
		$type = $this->getType($model->type);
		return $type;
	}
	
	protected function getType($type)
	{
		return $type=='1' ? 'Role' : 'Permission';
	}
}
