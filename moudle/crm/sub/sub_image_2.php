<?php

function GrabImage($url, $filename = "")
{
    if ($url == "")
        return false;

    if ($filename == "") {
        $ext = strrchr($url, ".");
        if ($ext != ".gif" && $ext != ".jpg" && $ext != ".png")
            return false;
        $filename = date("YmdHis") . $ext;
    }

    ob_start();
    readfile($url);
    $img = ob_get_contents();
    ob_end_clean();
    $size = strlen($img);
       if (!file_exists('images/users'))
       {
        mkdir('images/users', 0666, true);
       }
                
    $fp2 = @fopen("images/users/".$filename, "a");
    fwrite($fp2, $img);
    fclose($fp2);

    return $filename;
}
//$img = GrabImage("http://wx.qlogo.cn/mmopen/DYAIOgq83eqrR0nOh6fibcldibu6Z72APXsXZfaPIm3eP1CryJwdOzZJialTM2LWkzicU0gbHMlblnum0Hic7K4yCiaA/0","111.jpg");
//echo $img;



function get_time_diff($t)
{
    $time = date('Y-m-d H:i:s', time());
    $time = strtotime($time);
    //echo $time;exit;
     $aaa=date("YmdHis", $time);
     // $time = date('Y-m-d H:i:s', time());
    $t = strtotime($t);
    //echo $time;exit;
     $t=date("YmdHis", $t);
     $a = timeDiff($aaa, $t);
     return $a;
}





class resizeimage
{
    //ͼƬ����
    var $type;
    //ʵ�ʿ��
    var $width;
    //ʵ�ʸ߶�
    var $height;
    //�ı��Ŀ��
    var $resize_width;
    //�ı��ĸ߶�
    var $resize_height;
    //�Ƿ��ͼ
    var $cut;
    //Դͼ��
    var $srcimg;
    //Ŀ��ͼ���ַ[separator]
    var $dstimg;
    //��????����ͼ��
    var $im;

    function resizeimage($img, $wid, $hei, $c)
    {
        $this->srcimg = $img;
        $this->resize_width = $wid;
        $this->resize_height = $hei;
        $this->cut = $c;
        //ͼƬ������
        $this->type = substr(strrchr($this->srcimg, "."), 1);
        //��ʼ��ͼ��
        $this->initi_img();
        //Ŀ��ͼ���ַ
        $this->dst_img();
        //--
        $this->width = imagesx($this->im);
        $this->height = imagesy($this->im);
        //����ͼ��
        $this->newimg();
        ImageDestroy($this->im);
        return $guige =array("width"=>$this->width,"height"=>$this->height,"resize_width"=>$resize_width,"resize_height"=>$resize_width);
    }
    function newimg()
    {
        //�ı���ͼ��ı���
        $resize_ratio = ($this->resize_width) / ($this->resize_height);
        //ʵ��ͼ��ı���
        $ratio = ($this->width) / ($this->height);
        if (($this->cut) == "1") //��ͼ
            {
            if ($ratio >= $resize_ratio) //�߶�����
                {
                $newimg = imagecreatetruecolor($this->resize_width, $this->resize_height);
                imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width, $this->
                    resize_height, (($this->height) * $resize_ratio), $this->height);
                ImageJpeg($newimg, $this->dstimg);
            }
            if ($ratio < $resize_ratio) //�������
                {
                $newimg = imagecreatetruecolor($this->resize_width, $this->resize_height);
                imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width, $this->
                    resize_height, $this->width, (($this->width) / $resize_ratio));
                ImageJpeg($newimg, $this->dstimg);
            }
        } else //����ͼ
        {
            if ($ratio >= $resize_ratio) {
                $newimg = imagecreatetruecolor($this->resize_width, ($this->resize_width) / $ratio);
                imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width, ($this->
                    resize_width) / $ratio, $this->width, $this->height);
                ImageJpeg($newimg, $this->dstimg);
            }
            if ($ratio < $resize_ratio) {
                $newimg = imagecreatetruecolor(($this->resize_height) * $ratio, $this->
                    resize_height);
                imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, ($this->resize_height) * $ratio,
                    $this->resize_height, $this->width, $this->height);
                ImageJpeg($newimg, $this->dstimg);
            }
        }
    }
    //��ʼ��ͼ��
    function initi_img()
    {
        if ($this->type == "jpg") {
            $this->im = imagecreatefromjpeg($this->srcimg);
        }
        if ($this->type == "gif") {
            $this->im = imagecreatefromgif($this->srcimg);
        }
        if ($this->type == "png") {
            $this->im = imagecreatefrompng($this->srcimg);
        }
    }
    //ͼ��Ŀ���ַ
    function dst_img()
    {
        $full_length = strlen($this->srcimg);
        $type_length = strlen($this->type);
        $name_length = $full_length - $type_length;
        $name = substr($this->srcimg, 0, $name_length - 1);
        $this->dstimg = "s_" . $name . "." . $this->type;
    }
}


function get_img()
{
    $sql = "select img_goods_sn,img_url from goods_images ;";
    $res = $GLOBALS['db']->query($sql);

    return array('sql' => $sql);
}

class upload
{
    public $upload_file = array();
    public $upload_path = 'upload/goods';
    public $timetree = 1;
    public $allow = array('jpg', 'gif', 'bmp', 'jpeg', 'png');
    public $guige='';
   
    function uplood_img($path = '')
    {
        if (!isset($_FILES))
            return $this->error(99);
        if ($path)
            $this->upload_path = $path;
        if ($_FILES && $this->timetree) {
            //$this->upload_path .= date('/Y/m/d');
            if (!file_exists($this->upload_path))
                mkdir($this->upload_path, 0666, true);
            if (!file_exists("s_".$this->upload_path))
                mkdir("s_".$this->upload_path, 0666, true);
        }
        foreach ($_FILES as $info) {
            if (!is_array($info['name'])) {
                $this->upload_callback($info);
                continue;
            }
            for ($i = 0; $i < count($info['name']); $i++) {
                $this->upload_callback(array('name' => $info['name'][$i], 'type' => $info['type'][$i],
                    'tmp_name' => $info['tmp_name'][$i], 'error' => $info['error'][$i], 'size' => $info['size'][$i], ));
            }
        }
    }

    /**
     * �ϴ�����ص�����
     * ���� �����ϴ��ļ�
     **/
    function upload_callback($info)
    {
        if ($info['error'])
            return $this->error($info['error']);
        if (!($ext = $this->extension($info['name'])))
            return;
        $t = date('YmdHis');
        $n = 0;
        do {
            $name2=$info['name'];
            $name2=  mb_convert_encoding($name2,"GBK","UTF-8");
            //$filename = sprintf('%s/%s%03d.%s', $this->upload_path, $t, $n++, $ext);
            $filename = sprintf('%s/%s', $this->upload_path, $t.$n."_".$name2, $n++, $ext);
            
        } while (file_exists($filename));
       
        $name3=  mb_convert_encoding($filename,"UTF-8","GBK");
       
       
        copy($info['tmp_name'], $filename);
        $filename=  mb_convert_encoding($filename,"UTF-8","GBK");
        $this->upload_file[] = $filename;
        ////echo str_replace("???upload/goods/"," ",$url);
//        $us_name = trim(str_replace("???upload/goods/", " ", $filename));
//        $resizeimage = new resizeimage($us_name, "240", "178", "1");
//        //$resizeimage = new resizeimage($us_name, "440", "440", "1");
//        $this->upload_file['guige'][]=$resizeimage;
        //print_r($resizeimage);exit;
       //  print_r(str_replace("???upload/goods/"," ",$url));

    }
    function extension($filename)
    {
        $t = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if (in_array($t, $this->allow))
            return $t;
        $this->error("$t �Ƿ�������");
        return '';
    }
    /**
     * ������
     **/
    function error($errno)
    {
        $msg = '';
        switch ($errno) {
            case UPLOAD_ERR_INI_SIZE:
                $msg = '�ϴ����ļ������� ' . ini_get('upload_max_filesize');
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $msg = '�ϴ��ļ��Ĵ�С������ HTML ���� MAX_FILE_SIZE ѡ��ָ����ֵ';
                break;
            case UPLOAD_ERR_PARTIAL:
                $msg = '�ļ�ֻ�в��ֱ��ϴ�';
                break;
            case UPLOAD_ERR_NO_FILE:
                $msg = 'û���ļ����ϴ�';
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $msg = '�Ҳ�����ʱ�ļ���';
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $msg = '�ļ�д��ʧ��';
                break;
            default:
                $msg = '����:' . $errno;
                break;
        }
        if ($errno != 4) {
            echo "<script>alert('$msg');</script>";
        }

    }
}

//$p = new upload;
//print_r($p->upload_file);


//$resizeimage = new resizeimage("test.jpg", "150", "174", "1");





function arr_push($img2)
{
    foreach ($img2 as $k => $_v) {

        array_push($_v, $k);
        $img[] = $_v;
    }
    for ($i = 0; $i < count($img); $i++) {
        $img[$i][0] = $img[$i][0] + 1;
    }
    return $img;
}

?>