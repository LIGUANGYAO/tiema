<?php

define('IN_ECS', true);
//include('page.php');
require(dirname(__FILE__) . '/sub/sub_set_index.php');
require (dirname(__file__) . '/includes/init.php');


if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

$action=$_GET['action'];
$news_id=$_GET['id'];


//print_r($action);
/**

 * if ($_REQUEST['act'] == 'default') {
 *     
 *     $smarty->display('reply_text.tpl');
 * }
 */

switch ($action){

	case 'selectone':

		//查询单条相关信息
		$sql="select title,content from news where id=".$news_id;
		$res=mysql_query($sql);
		$row1=mysql_fetch_array($res);
		$smarty->assign('title',$row1['title']);
		$smarty->assign('date',$row1['time']);
		$smarty->assign('content',$row1['content']);

		$smarty->display('singleNews.tpl');
		break;
        
        case 'add':
         
         insert_set_index_mx();
         //$set_index=get_set_index_mx();
         //$smarty->assign('set_index_mx', $set_index['items'][0]);
         
         $smarty->display('set_index.tpl');         
         break;
         

	    case 'addnews':
       // print_r($action);
        $smarty->assign('action',"addnews");
        $smarty->display('set_index.tpl');
        
	    break;    
        
        
        
  
	case 'delete':
        delete_news_mx($news_id);
        $news_list=get_news_list($Num);
        $smarty->assign('news', $news_list['items']);
        $smarty->assign('p_Array', $news_list['page']);
        $smarty->display('reply_text.tpl');
		break;
        
        
    case 'update':
        $set_index=get_set_index_mx();
        $smarty->assign('set_index', $set_index['items'][0]);
        
        //print_r( $set_index['items'][0]['imgurl']);
        
        if (file_exists("files/".$set_index['items'][0]['imgurl']))
        {
            $file_path="files/".$set_index['items'][0]['imgurl'];          
            $smarty->assign("file_path",$file_path);
        }
        
		$smarty->assign("action","update");
		$smarty->display('set_index.tpl');
		break;
    case 'edit':
        update_set_index_mx($news_id);
        $smarty->assign('news', $news_list['items']);
        $smarty->display('set_index.tpl');
		break;

	default:

       
	    //$news_list=get_news_list($Num);
        //$smarty->assign('news', $news_list['items']);
        //$smarty->assign('p_Array', $news_list['page']);
		$smarty->display('set_index.tpl');
}

?>
