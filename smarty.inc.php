

 

<?php 

 

   /***

 

     模板配置 sunhaiming

 

   **/

 

   include_once("smarty/Smarty.class.php"); //导入模板文件

 

   $smarty = new Smarty();//创建smarty对象

 

   $smarty->config_dir = "/smarty/Config_File.class.php";  //目录变量

 

   $smarty->caching = false; //是否使用缓存

 

   $smarty->template_dir = "./templates"; //设置模板目录

 

   $smarty->compile_dir = "./templates_c";//设置编译目录

 

   $smarty->cache_dir = "./smarty_cache";//缓存文件

 

   //-------------------------------------------------------------

 

    //左右边界符

 

    //-------------------------------------------------------------

 

         $smarty->left_delimiter = "{"  ;

 

         $smarty->right_delimiter="}";

 

 ?>
