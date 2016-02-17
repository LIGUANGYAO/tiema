<?php
	 function content($type,$openid,$msg)
    {
        switch ($type) {
            case 'text':
                $array = array();
                $array[0]['touser'] = $openid;
                //$array[0]['touser'] = 'osh4wuKGcSNz2jhQY1Rll4nx0Bm4';
                $array[0]['content'] = $msg;


                $res = array();
                foreach ($array as $resc) {


                    $res['touser'] = $resc['touser'];
                    $res['msgtype'] = 'text';
                    $res['text']['content'] = urlencode($resc['content']);

                    $datas = json_encode($res);
                    $data[] = urldecode($datas);
                }

                break;
            case 'news':
                $array = array();
                for ($i = 0; $i < 1; $i++) {
                    $array[$i]['touser'] = $openid;
                    //$array[$i]['touser'] = 'osh4wuKGcSNz2jhQY1Rll4nx0Bm4';
                    $array[$i]['msgtype'] = 'msgtype';
                    $array[$i]['news']['articles'][0]['title'] = '新的工单：我要报修';
                    $array[$i]['news']['articles'][0]['description'] =
                        '我要报修我要报修我要报修我要报修我要报修我要报修我要报修我要报修我要报修';
                    $array[$i]['news']['articles'][0]['url'] = 'http://baidu.com';
                    $array[$i]['news']['articles'][0]['picurl'] = 'http://www.baidu.com';

                }

                $res = array();
                foreach ($array as $resc) {
                    $res['touser'] = $resc['touser'];
                    $res['msgtype'] = 'news';
                    $re = array();
                    $res['news']['articles'] = array();
                    foreach ($resc['news']['articles'] as $articles) {
                        $re['title'] = urlencode($articles['title']);
                        $re['description'] = urlencode($articles['description']);
                        $re['url'] = urlencode($articles['url']);
                        $re['picurl'] = urlencode($articles['picurl']);
                        $res['news']['articles'][] = $re;

                    }

                    $datas = json_encode($res);
                    $data[] = urldecode($datas);
                }
                break;
        }
        return $data;
    }

    function send($data)
    {
        $obj = new getArrToken();
        $result = $obj->getToken();
        //echo $result;
        foreach ($data as $res) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,
                "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$result.'");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_USERAGENT,
                'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
            //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $res);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $tmpInfo2 = curl_exec($ch);
            $tmpInfo3 = (array )json_decode($tmpInfo2);
            if($tmpInfo3['errcode']=='45015')
            {
                $error="发送失败,该用户48小时内未产生交互信息";
                
                
                $msg['item']=array(array('errcode'=>'45015','errmsg'=>$error));
                $msg['sum']="1";
                return $msg;
//                print_r(json_encode($msg));
            }
            elseif($tmpInfo3['errcode']=='40001')
            {
                $obj = new getArrToken();
                $result = $obj->resetToken();
                $error="token失效";
                //$msg=array('errcode'=>'40001','errmsg'=>$error);
                
                
                $msg['item']=array(array('errcode'=>'40001','errmsg'=>$error));
                $msg['sum']="1";
                return $msg;
                //print_r(json_encode($msg));
            }
            elseif($tmpInfo3['errcode']=='0')
            {
                $error="消息发送成功";
                //$msg=array('errcode'=>'0','errmsg'=>$error);
                
                $msg['item']=array(array('errcode'=>'0','errmsg'=>$error));
                $msg['sum']="1";
                return $msg;
                //print_r(json_encode($msg));
            }
            else
            {
                $msg['item']=array($tmpInfo2);
                $msg['sum']="1";
                //print_r($tmpInfo2);
                return $msg;
            }
            
            if (curl_errno($ch)) {
                echo 'Errno' . curl_error($ch);
            }
            curl_close($ch);
        }
    }
    
    function content2($type, $openid, $list)
    {
        switch ($type) {
         
            case 'news':
                $array = array();
                for ($i = 0; $i < count($list); $i++) {
                    $array[0]['touser'] = $openid;
                    //$array[$i]['touser'] = 'osh4wuKGcSNz2jhQY1Rll4nx0Bm4';
                    $array[0]['msgtype'] = 'msgtype';
                    $array[0]['news']['articles'][$i]['title'] = $list[$i]['title'];
                    $array[0]['news']['articles'][$i]['description'] =
                        $list[$i]['note'];
                    $array[0]['news']['articles'][$i]['url'] = $list[$i]['link'];
                    $array[0]['news']['articles'][$i]['picurl'] = $list[$i]['cover'];
//$reuslt = content2('news', $openid, $img_list[0]['title'],$img_list[0]['note'],$img_list[0]['link'],$img_list[0]['cover']);
                }

                $res = array();
                foreach ($array as $resc) {
                    $res['touser'] = $resc['touser'];
                    $res['msgtype'] = 'news';
                    $re = array();
                    $res['news']['articles'] = array();
                    foreach ($resc['news']['articles'] as $articles) {
                        $re['title'] = urlencode($articles['title']);
                        $re['description'] = urlencode($articles['description']);
                        $re['url'] = urlencode($articles['url']);
                        $re['picurl'] = urlencode($articles['picurl']);
                        $res['news']['articles'][] = $re;

                    }

                    $datas = json_encode($res);
                    $data[] = urldecode($datas);
                }
                break;
        }
        return $data;
    }
    
    
  
?>