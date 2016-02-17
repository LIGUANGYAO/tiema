<?php
function getImage($url, $save_dir = '', $filename = '', $type = 0)
{
    $pic = file_get_contents('http://i2.tietuku.com/1b776066fa782b78.jpg');
    ob_flush();
    file_put_contents('1.jpg', $pic);
}

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

    ob_clean();
    flush();

    ob_start();
    readfile($url);
    $img = ob_get_contents();
    ob_end_clean();
    $size = strlen($img);
    if (!file_exists('upload/users')) {
        mkdir('upload/users', 0666, true);
    }

    $fp2 = @fopen("upload/users/" . $filename, "a");
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
    $aaa = date("YmdHis", $time);
    // $time = date('Y-m-d H:i:s', time());
    $t = strtotime($t);
    //echo $time;exit;
    $t = date("YmdHis", $t);
    $a = timeDiff($aaa, $t);
    return $a;
}


class resizeimage
{
    //图片类型
    var $type;
    //实际宽度
    var $width;
    //实际高度
    var $height;
    //改变后的宽度
    var $resize_width;
    //改变后的高度
    var $resize_height;
    //是否裁图
    var $cut;
    //源图象
    var $srcimg;
    //目标图象地址[separator]
    var $dstimg;
    //临????建的图象
    var $im;

    function resizeimage($img, $wid, $hei, $c)
    {
        $this->srcimg = $img;
        $this->resize_width = $wid;
        $this->resize_height = $hei;
        $this->cut = $c;
        //图片的类型
        $this->type = substr(strrchr($this->srcimg, "."), 1);
        //初始化图象
        $this->initi_img();
        //目标图象地址
        $this->dst_img();
        //--
        $this->width = imagesx($this->im);
        $this->height = imagesy($this->im);
        //生成图象
        $this->newimg();
        ImageDestroy($this->im);
        return $guige = array("width" => $this->width, "height" => $this->height,
            "resize_width" => $resize_width, "resize_height" => $resize_width);
    }
    function newimg()
    {
        //改变后的图象的比例
        $resize_ratio = ($this->resize_width) / ($this->resize_height);
        //实际图象的比例
        $ratio = ($this->width) / ($this->height);
        if (($this->cut) == "1") //裁图
            {
            if ($ratio >= $resize_ratio) //高度优先
                {
                $newimg = imagecreatetruecolor($this->resize_width, $this->resize_height);
                imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width, $this->
                    resize_height, (($this->height) * $resize_ratio), $this->height);
                ImageJpeg($newimg, $this->dstimg);
            }
            if ($ratio < $resize_ratio) //宽度优先
                {
                $newimg = imagecreatetruecolor($this->resize_width, $this->resize_height);
                imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width, $this->
                    resize_height, $this->width, (($this->width) / $resize_ratio));
                ImageJpeg($newimg, $this->dstimg);
            }
        } else //不裁图
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
    //初始化图象
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
    //图象目标地址
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
    public $guige = '';
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
            if (!file_exists("s_" . $this->upload_path))
                mkdir("s_" . $this->upload_path, 0666, true);
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
     * 上传处理回调方法
     * 功能 保存上传文件
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
            $filename = sprintf('%s/%s%03d.%s', $this->upload_path, $t, $n++, $ext);
        } while (file_exists($filename));
        copy($info['tmp_name'], $filename);
        $this->upload_file[] = $filename;
        //echo str_replace("???upload/goods/"," ",$url);
        $us_name = trim(str_replace("???upload/goods/", " ", $filename));
        $resizeimage = new resizeimage($us_name, "240", "178", "1");
        //$resizeimage = new resizeimage($us_name, "440", "440", "1");
        $this->upload_file['guige'][] = $resizeimage;
        //print_r($resizeimage);exit;
        //  print_r(str_replace("???upload/goods/"," ",$url));

    }
    function extension($filename)
    {
        $t = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if (in_array($t, $this->allow))
            return $t;
        $this->error("$t 非法的类型");
        return '';
    }
    /**
     * 错误处理
     **/
    function error($errno)
    {
        $msg = '';
        switch ($errno) {
            case UPLOAD_ERR_INI_SIZE:
                $msg = '上传的文件超过了 ' . ini_get('upload_max_filesize');
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $msg = '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值';
                break;
            case UPLOAD_ERR_PARTIAL:
                $msg = '文件只有部分被上传';
                break;
            case UPLOAD_ERR_NO_FILE:
                $msg = '没有文件被上传';
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $msg = '找不到临时文件夹';
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $msg = '文件写入失败';
                break;
            default:
                $msg = '错误:' . $errno;
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


function curl_get_contents($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

function downloadWeixinFile($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_NOBODY, 0); //只取body头
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $package = curl_exec($ch);
    $httpinfo = curl_getinfo($ch);
    curl_close($ch);
    $imageAll = array_merge(array('header' => $httpinfo), array('body' => $package));
    return $imageAll;
}

function saveWeixinFile($filename, $filecontent)
{
    $local_file = fopen($filename, 'w');
    if (false !== $local_file) {
        if (false !== fwrite($local_file, $filecontent)) {
            fclose($local_file);
        }
        return true;
    }
    else
    {
        return false;
    }
}


?>