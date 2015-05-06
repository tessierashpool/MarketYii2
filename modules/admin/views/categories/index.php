<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories(tree)');
$this->params['breadcrumbs'][] = $this->title;


function treeGenerator($arCat = [], $parent_id=0, $debth=0)
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
                        echo ' <a href="javascript:void(0)" onclick="folderOrderUp('.$cat['id'].')"><i class="glyphicon glyphicon-arrow-up"></i></a>';                        
                        echo ' <a href="javascript:void(0)" onclick="folderOrderDown('.$cat['id'].')"><i class="glyphicon glyphicon-arrow-down"></i></a>';                        

                    echo '</span>';
                echo '</div>';
                       
                echo '<ul>';
                    unset($arCat[$key]);
                    $arCat = treeGenerator($arCat, $id, $debth + 1);
                    echo '<li> <a href="'.Url::to(['create', 'parent' => $cat['id'], 'depth'=>$cat['depth']+1]).'" class="folder folder-create"><i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create subcategory').'</a></li>';
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
        <?= Html::a(Yii::t('app', 'Create Category'), ['create'], ['class' => 'btn btn-success']) ?>
        <?//= Html::a(Yii::t('app', 'Create Category in Table'), ['create-table'], ['class' => 'btn btn-success']) ?>
    </p>
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
            color: #000;
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
            font-size: 12px;
        } 
        .menu-button{
            cursor: pointer;
        }  
    </style>
    <script>
        function openAllFolders()
        {
            $('.folder-input').prop('checked',true);
        }

        function closeAllFolders()
        {
            $('.folder-input').prop('checked',false);
        }  

        function folderOrderUp(id){
            var curent_li = $('.folder-li-'+id);
            var prev_li = curent_li.prev('.folder-li');
 /*           if(prev_li.length)
                alert(prev_li.data('folder-order'));*/
            if(prev_li.length)
            {    
                curent_li.after(prev_li);
                $.ajax({
                   url: '<?=Url::to(['ajax-order-change'])?>',
                   data: {id1: id, id2: prev_li.data('folder-id')}                 
                });                
            } 
        }    

         function folderOrderDown(id){
            var curent_li = $('.folder-li-'+id);
            var next_li = curent_li.next('.folder-li');
            if(next_li.length)    
            {
                curent_li.before(next_li);
                $.ajax({
                   url: '<?=Url::to(['ajax-order-change'])?>',
                   data: {id1: id, id2: next_li.data('folder-id')}                  
                });                   
            } 
        }          
    </script>
    <?//var_dump($dataTree)?>
    <hr>
    <p><span onclick="openAllFolders()" class="folder menu-button"><i class="glyphicon glyphicon-folder-open foldeer-icon-open"></i>&nbsp; Open all folders</span>
        &nbsp;<span onclick="closeAllFolders()" class="folder menu-button"><i class="glyphicon glyphicon-folder-close foldeer-icon-close"></i>&nbsp;Close all folders</span></p>
    <hr>
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
