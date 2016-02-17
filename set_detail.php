<?php

define('IN_ECS', true);
include('page.php');
require(dirname(__FILE__) . '/sub/sub_set_detail.php');
require (dirname(__file__) . '/includes/init.php');


if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

$action=$_GET['action'];
$news_id=$_GET['id'];
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
         
         insert_news_mx();
         $sql = "SELECT  * FROM news order by id desc limit 1"; //这时候$Sql = "SELECT * FROM message limit 0,10";
         $res = $GLOBALS['db']->getAll($sql); //已当前$i的值，也就是当前是第几页来给$Sql 和$Result 为名字\
        
         //print_r($res[0]);
         
         $htmlname=$res[0]['htmlurl'];
         //开始替换了
         $smarty->assign("news1",$res[0]);
        // $Smarty->assign("MenuTop",$MenuTop) //上一页
        // $Smarty->assign("MenuNext",$MenuNext) //下一页
         $content = $smarty->fetch('w_detail.tpl',null,null,false); //用$Content[$i] 得到每页的内容
         //print_r($content);
         //替换完了，我们把内容写到文件里
         if(file_exists($htmlname)){
         @unlink($htmlname) ; //如果文件已经存在就把它删除
         }
         $fp = fopen('html/'.$htmlname,"w"); //以可写方式打开$HtmlName ，第一次循环是打开index_1.html
         fwrite($fp,$content); //用fwrite()函数， 把内容写入每个文件
         fclose($fp);//关闭打开的文件指针
         
         $news_list=get_news_list($Num);
         $smarty->assign('news', $news_list['items']);
         $smarty->assign('p_Array', $news_list['page']);
         $smarty->display('set_detail.tpl');         
         break;

	case 'addnews':
     
     
        $news_menu=get_newsmenu();
        
        //print_r($news_menu['items']);
        $smarty->assign('news_menu', $news_menu['items']);
     
		$smarty->assign("action","addnews");
		$smarty->display('set_detail_add.tpl');
		break;

	case 'delete':
        delete_news_mx($news_id);
        $news_list=get_news_list($Num);
        $smarty->assign('news', $news_list['items']);
        $smarty->assign('p_Array', $news_list['page']);
        $smarty->display('set_detail.tpl');
		break;

	case 'update':
        $newsmx=get_newsmx();
        $smarty->assign('news_mx', $newsmx['items'][0]);
        
        $news_menu=get_newsmenu();
        //print_r($news_menu['items']);
        $smarty->assign('news_menu', $news_menu['items']);
        
        
        
		$smarty->assign("action","update");
		$smarty->display('set_detail_add.tpl');
		break;
     case 'edit':
        update_news_mx($news_id);
        
         $htmlname=date("YmdHis");
         $sql = "SELECT  * FROM news where id=$news_id;"; //这时候$Sql = "SELECT * FROM message limit 0,10";
         $res = $GLOBALS['db']->getAll($sql); //已当前$i的值，也就是当前是第几页来给$Sql 和$Result 为名字\
        
         //print_r($res[0]);
         $sql1 = "SELECT  * FROM menu_list where p_name is null "; //这时候$Sql = "SELECT * FROM message limit 0,10";
         $res1 = $GLOBALS['db']->getAll($sql1); //已当前$i的值，也就是当前是第几页来给$Sql 和$Result 为名字\
        
         //print_r($res1);
         $smarty->assign("menu_list",$res1);
         //开始替换了
         $smarty->assign("news1",$res[0]);
        // $Smarty->assign("MenuTop",$MenuTop) //上一页
        // $Smarty->assign("MenuNext",$MenuNext) //下一页
         $content = $smarty->fetch('detail.tpl',null,null,false); //用$Content[$i] 得到每页的内容
         //print_r($content);
         //替换完了，我们把内容写到文件里
         if(file_exists($htmlname)){
         @unlink($htmlname) ; //如果文件已经存在就把它删除
         }
         $fp = fopen('html/'.$htmlname.'.html',"w"); //以可写方式打开$HtmlName ，第一次循环是打开index_1.html
         fwrite($fp,$content); //用fwrite()函数， 把内容写入每个文件
         fclose($fp);//关闭打开的文件指针
        
        
        
        
        
        $news_list=get_news_list($Num);
        $smarty->assign('news', $news_list['items']);
        $smarty->assign('p_Array', $news_list['page']);
        $smarty->display('set_detail.tpl');
		break;

	default:

       
	    $news_list=get_news_list($Num);
        $smarty->assign('news', $news_list['items']);
        $smarty->assign('p_Array', $news_list['page']);
		$smarty->display('set_detail.tpl');
}

?>
