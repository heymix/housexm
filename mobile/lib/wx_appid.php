<?php use config\Result;



function getTiket($db_name,$con,$char_set){
    
    mysql_select_db($db_name, $con);          //选择数据库
    $result = new Result();
    $token="";
    $jsapiTicket="";
    //取全局jsapi_ticket 缓存
    $query = "select id,content from t_wx_appid where id=2 and end_time>now();";                   //SQL查询语句
    mysql_query($char_set);
    $rs = mysql_query($query, $con);
    if(!$rs){die("0|Valid result!");}
    if(mysql_num_rows($rs)>=1){
        $row     = mysql_fetch_array($rs);
        $jsapiTicket=$row["content"];
        $result = new Result();
        $result->setIsSuccess(true);
        $result->setResult($jsapiTicket);
        $result->setMessage("获取成功！来自缓存。");
    }else{
        //第一步取token缓存
        $query = "select id,content from t_wx_appid where id=1 and end_time>now();";                   //SQL查询语句
        mysql_query($char_set);
        $rs = mysql_query($query, $con);
        if(!$rs){die("0|Valid result!");}
        if(mysql_num_rows($rs)>=1){
            $row     = mysql_fetch_array($rs);
            $token=$row["content"];
        }else{
            //缓存不存在 取微信token
            $content=file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxa1ea38b40c9e8b55&secret=17986fd0182509a06a1f724ce9102118");
            if(strpos($http_response_header[0], "200")>0){
                $query="update t_wx_appid set `content`='$content',end_time=DATE_ADD(now(), INTERVAL 115 MINUTE) where id=1";
                $isSuccess=mysql_query($query,$con);
                if($isSuccess===false){
                    $result = new Result();
                    $result->setIsSuccess(false);
                    $result->setMessage("失败： 存token缓存失败！错误代码：db001");
                    die(json_encode($result));
                }else{
                    //取token成功
                    $token=json_decode($content);
                }
            }else{
                $result = new Result();
                $result->setIsSuccess(false);
                $result->setMessage("获取失败!调用微信接TOKEN 口失败！");
                die(json_encode($result));
            }
        }
        //去微信中取jsapi_ticket
        if(!empty($token)){
            $tokenArray=json_decode($token,true);
            $jsapiTicket=file_get_contents("https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$tokenArray['access_token']."&type=jsapi");
            if(strpos($http_response_header[0], "200")>0){
                $query="update t_wx_appid set `content`='$jsapiTicket',end_time=DATE_ADD(now(), INTERVAL 115 MINUTE) where id=2";
                $isSuccess=mysql_query($query,$con);
                if($isSuccess===false){
                    $result = new Result();
                    $result->setIsSuccess(false);
                    $result->setMessage("失败： 存jsapi_ticket缓存失败！错误代码：db001");
                    die(json_encode($result));
                }else{
            
                    $result = new Result();
                    $result->setIsSuccess(true);
                    $result->setResult($jsapiTicket);
                    $result->setMessage("获取成功！来自微信，并存入缓存。");
                    
                }
            }else{
                $result = new Result();
                $result->setIsSuccess(false);
                $result->setMessage("获取失败!调用微信接jsapi_ticket 口失败！");
                die(json_encode($result));
            }
            
        }else{
            $result = new Result();
            $result->setIsSuccess(false);
            $result->setMessage("获取失败!调用微信接口失败！");
            die(json_encode($result));
        }
    }
    mysql_close($con);
    return $result;
}
?>
