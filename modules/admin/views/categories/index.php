<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories');
$this->params['breadcrumbs'][] = $this->title;


function treeGenerator($arCat = [], $parent_id=0, $debth=0)
{       
    foreach($arCat as $key=> $cat)
    {
        if(($cat['parent_id']==null&&$debth==null)||$parent_id == $cat['parent_id'])
        {
            $id = $cat['id'];           
            echo '<li>';            
                echo '<input class="folder-input" type="checkbox" id="subfolder_'.$cat['id'].'"/>';
                echo '<div class="folder">';
                    echo '<label for="subfolder_'.$cat['id'].'">';
                        echo '<i class="glyphicon glyphicon-folder-close foldeer-icon-close"></i>';
                        echo '<i class="glyphicon glyphicon-folder-open foldeer-icon-open"></i>';
                        echo '&nbsp;'.$cat['name'];
                    echo '</label>&nbsp;&nbsp;';
                    echo '<span class="actions">';
                        echo '<a href="'.Url::to(['view', 'id' => $cat['id']]).'"><i class="glyphicon glyphicon-eye-open"></i></a>';
                        echo ' <a href="#"><i class="glyphicon glyphicon-pencil"></i></a>';
                        echo ' <a href="#"><i class="glyphicon glyphicon-trash"></i></a>';
                    echo '</span>';
                echo '</div>';
                       
                echo '<ul>';
                    unset($arCat[$key]);
                    $arCat = treeGenerator($arCat, $id, $debth + 1);
                    echo '<li> <a href="'.Url::to(['create', 'parent' => $cat['id'], 'depth'=>$cat['depth']+1]).'" class="folder folder-create"><i class="glyphicon glyphicon-plus"></i> Создать подкатегорию</a></li>';
                echo '</ul>';                       
            echo '</li>';      
        }
    }
    if(count($arCat)>0)
        return $arCat;
}

?>
<div class="categories-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Categories'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'code',
            'name',
            'description',
            'parent_id',
            // 'depth',
            // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <style>
        #ultest ul {
            list-style: none;
        }
        #ultest ul input + div + ul{
            display: none;
        }        
        #ultest ul input:checked + div + ul{
            display: block;
        }  
        #ultest  i.foldeer-icon-open{
            display: none;
        }          
        #ultest ul input:checked + div i.foldeer-icon-open{
            display: inline;
        }   
        #ultest ul input:checked + div i.foldeer-icon-close{
            display: none;
        }                     
        .folder{
            border: 1px solid #fff;
            height: 30px;
            line-height: 30px;
            display: inline-block;
            padding-left: 10px;
            padding-right: 10px;          
        }
        .folder:hover{
            border: 1px solid #eee;
        }    
        .folder label{
            font-weight: normal;
            cursor: pointer;
        }   
        .folder label:hover{
            
        }          
        .folder-input{
            display: none;
        }                         
        .folder i.foldeer-icon-open,.folder i.foldeer-icon-close{
            color: #f0ad4e;
        }     
        .folder .actions{
        }        
        a.folder-create{
            text-decoration: none;
            cursor: pointer;
            color: #444;
        }   
    </style>
    <?//var_dump($dataTree)?>
    <div id="ultest">
    <ul style="padding-left: 0;">
        <?=treeGenerator($dataTree);?>
    </ul>
    </div>
<!--       <div id="ultest">
<ul style="padding-left: 0;">
     <li>
   <input class="folder-input" type="checkbox" id="subfolder1" /> 
   <div class="folder">
       <label for="subfolder1">
           <i class="glyphicon glyphicon-folder-close foldeer-icon-close"></i>
           <i class="glyphicon glyphicon-folder-open foldeer-icon-open"></i>
           &nbsp;Категория1
       </label>&nbsp;&nbsp;
       <span class="actions">
           <a href="#"><i class="glyphicon glyphicon-eye-open"></i></a>
           <a href="#"><i class="glyphicon glyphicon-pencil"></i></a>
           <a href="#"><i class="glyphicon glyphicon-trash"></i></a>
       </span>
   </div>
          
   <ul>
       <li> <div class="folder"><i class="glyphicon glyphicon-folder-close foldeer-icon-close"></i>&nbsp;&nbsp;Подкатегория1</div></li>
       <li> <div class="folder"><i class="glyphicon glyphicon-folder-close foldeer-icon-close"></i>&nbsp;&nbsp;Подкатегория2</div></li>
       <li> <div class="folder"><i class="glyphicon glyphicon-plus"></i> Создать</div></li>
   </ul>
     </li>
     <li> <div class="folder"><i class="glyphicon glyphicon-folder-close foldeer-icon-close"></i>&nbsp;&nbsp;Категория2</div></li>
     <li> <div class="folder"><i class="glyphicon glyphicon-folder-close foldeer-icon-close"></i>&nbsp;&nbsp;Категория3</div></li>
</ul>
</div>  -->
</div>
