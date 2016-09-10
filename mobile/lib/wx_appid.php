<?php use config\Result;
include '../config/config.php';

$action=$_POST["action"];
$id=$_POST["id"];
mysql_select_db($db_name, $con);          //选择数据库
mysql_query($char_set);

$result = new Result();

//取全局jsapi_ticket 缓存
$query = "select id,content from t_wx_appid where id=2 and end_time>now();";                   //SQL查询语句
mysql_query($char_set);
$rs = mysql_query($query, $con);
if(!$rs){die("0|Valid result!");}
if(mysql_num_rows($rs)>=1){
    $row     = mysql_fetch_array($rs);
    $token=json_decode($row["content"]);
    var_dump($token);
}else{
    //第一步取token缓存
    $query = "select id,content from t_wx_appid where id=1 and end_time>now();";                   //SQL查询语句
    mysql_query($char_set);
    $rs = mysql_query($query, $con);
    if(!$rs){die("0|Valid result!");}
    if(mysql_num_rows($rs)>=1){
        $row     = mysql_fetch_array($rs);
        $token=json_decode($row["content"]);
    }else{
        //缓存不存在 取微信token
        $content=file_get_contents("http://localhost/housexm/mobile/web/test.php");
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
        
    }else{
        $result = new Result();
        $result->setIsSuccess(false);
        $result->setMessage("获取失败!调用微信接口失败！");
        die(json_encode($result));
    }
}

?>
