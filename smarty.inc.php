

 

<?php 

 

   /***

 

     ģ������ sunhaiming

 

   **/

 

   include_once("smarty/Smarty.class.php"); //����ģ���ļ�

 

   $smarty = new Smarty();//����smarty����

 

   $smarty->config_dir = "/smarty/Config_File.class.php";  //Ŀ¼����

 

   $smarty->caching = false; //�Ƿ�ʹ�û���

 

   $smarty->template_dir = "./templates"; //����ģ��Ŀ¼

 

   $smarty->compile_dir = "./templates_c";//���ñ���Ŀ¼

 

   $smarty->cache_dir = "./smarty_cache";//�����ļ�

 

   //-------------------------------------------------------------

 

    //���ұ߽��

 

    //-------------------------------------------------------------

 

         $smarty->left_delimiter = "{"  ;

 

         $smarty->right_delimiter="}";

 

 ?>
