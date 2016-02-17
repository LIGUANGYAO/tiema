<?php

class wx_response
{
    public $openid;
    public $p_id;
    public $response_sn;

    public function in_response()
    {
        //判断用户的session是否存在在系统中
        $one = "select openid from  response_sessions where openid='" . $this->openid .
            "'";
        $one = $GLOBALS['db']->getRow($one);

        if (!empty($one)) {

        } else {
            if (!empty($this->openid)) {
                $sql = "insert into response_sessions(openid) values('" . $this->openid . "') ";
                $res = $GLOBALS['db']->query($sql);

            }
        }


    }

    public function update_response()
    {
        if (!empty($this->openid)) {
            $sql = "update  response_sessions set p_id='" . $this->p_id . "',response_sn='" .
                $this->response_sn . "' where openid='" . $this->openid . "'";
            $res = $GLOBALS['db']->query($sql);
            $this->p_id = $this->openid = '';
            //return $sql;
        }
    }


    public function get_response()
    {
        if (!empty($this->openid)) {
            $sql = " select * from response_sessions where openid='" . $this->openid . "'";
            $res = $GLOBALS['db']->getRow($sql);
            return $res;
        }
    }
}


class wx_custom
{
    public $custom_sn;
    public $content;
    

    function get_custom()
    {

        $sql = "select re_type,re_code,tzsy,custom_sn,custom_name,custom_note_1,text,case when p_id is null then custom_sn when p_id is not null then concat(p_id,'_',custom_sn) end   as p_id2  from custom where tzsy=0 and custom_sn='" .
            $this->custom_sn . "' ;";

        $list = $GLOBALS['db']->getRow($sql);

        return $list;
    }
    
    function get_response()
    {
        
        $arr=$this->get_custom();
        //if ($arr['custom_name'] == $content || 1==1) //添加为yate商品查询的二次开发
        if (!empty($arr))
                {
                if ($arr['re_type'] == 'text') {
                    $text = "select text from text_reply where text_sn='" . $arr['re_code'] .
                        "'";
                    $text_list = $GLOBALS['db']->getRow($text);

                    $data = $text_list['text'];

                    return $data;
                    //exit(W::response($xml, $data));
                } elseif ($arr['re_type'] == 'imgtext') {
                    $imgtext = "select b.img_note_1 as title,b.img_note_2 as note,b.b_img_url as cover,b.img_action_url as link from imgtext a,imgtext_imgs b where a.imgtext_sn=b.p_id and b.ss=1 and a.imgtext_sn='" .
                        $arr['re_code'] . "'";
                    $img_list = $GLOBALS['db']->getAll($imgtext);

                    $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);
                    for ($i = 0; $i < count($img_list); $i++) {
                        $img_list[$i]['cover'] = $url_this . "/" . $img_list[$i]['cover'];
                    }
                    $data = $img_list;
                    
                     return $data;
                    //exit(W::response($xml, $data, 'news'));
                }

            }
    }
    
}

?>