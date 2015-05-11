function openAllFolders()
{
    $('.folder-input').prop('checked',true);
}

function closeAllFolders()
{
    $('.folder-input').prop('checked',false);
}  

function folderOrderUp(id,url){
    var curent_li = $('.folder-li-'+id);
    var prev_li = curent_li.prev('.folder-li');
    if(prev_li.length)
    {    
        curent_li.after(prev_li);
        $.ajax({
           url: url,
           data: {id1: id, id2: prev_li.data('folder-id')}                 
        });                
    } 
}    

 function folderOrderDown(id,url){
    var curent_li = $('.folder-li-'+id);
    var next_li = curent_li.next('.folder-li');
    if(next_li.length)    
    {
        curent_li.before(next_li);
        $.ajax({
           url: url,
           data: {id1: id, id2: next_li.data('folder-id')}                  
        });                   
    } 
} 