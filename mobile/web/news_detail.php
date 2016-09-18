<?php use config\WxAppid;
include '../config/conn.php';
include '../config/WxAppid.php';
$appid= new WxAppid();




$userId=$_COOKIE["userId"];
$id=$_GET["id"];    
if(is_numeric($id)){
    mysql_select_db($db_name, $con);          //选择数据库
    mysql_query($char_set);
    $Query = "select * from t_promotion where  id=$id and is_del=0";
    $result     = mysql_query($Query);
    $rs     = mysql_fetch_array($result);
    if(!$rs){die("0|Valid result!$Query"); mysql_close($con);}
    $id = $rs["id"];
    $title= $rs["title"];
    $desc = $rs["desc"];
    $image =$rs["image"];
    $category =$rs["category"];
    $content =$rs["content"];
   
       
}else{
    echo "错误:入参非法";
    return false;
}
$result=$appid->getTiket($db_name, $con, $char_set);  
$apiTikets=$result->getResult();
$apiTiketsArray=json_decode($apiTikets,true);
$time=time();
$nonceStr=$appid->getRandChar(10);
$string1="jsapi_ticket=".$apiTiketsArray['ticket']."&noncestr=$nonceStr&timestamp=$time&url=http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$ticket=sha1($string1);

?>  
<!DOCTYPE html>
<html>
<head>
<title><?php echo $title;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width" /> 
<link rel="stylesheet" href="../jquery/jquery.mobile-1.3.2.min.css">
<script src="../jquery/jquery-1.8.3.min.js"></script>
<script src="../jquery/jquery.mobile-1.3.2.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">

wx.config({
    debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
    appId: '<?php echo $appid->appid;?>', // 必填，公众号的唯一标识
    timestamp: <?php echo $time;?>, // 必填，生成签名的时间戳
    nonceStr: '<?php echo $nonceStr;?>', // 必填，生成签名的随机串
    signature: '<?php echo $ticket;?>',// 必填，签名，见附录1
    jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
});


wx.ready(function () {
	wx.onMenuShareTimeline({
	    title: '测试测试', // 分享标题
	    link: 'http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>', // 分享链接
	    imgUrl: 'http://<?php echo $_SERVER['HTTP_HOST'];?>/housexm/upload/images/1473318065.jpg', // 分享图标
	    success: function () { 
	        // 用户确认分享后执行的回调函数
	        //alert("开始");
	    },
	    cancel: function () {
	        // 用户取消分享后执行的回调函数
	    	//alert("结束");
	    }
	});


	wx.onMenuShareAppMessage({
	    title: '测试测试', // 分享标题
	    desc: '分享给朋友', // 分享描述
	    link: 'http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>', // 分享链接
	    imgUrl: 'http://<?php echo $_SERVER['HTTP_HOST'];?>/housexm/upload/images/1473318065.jpg', // 分享图标
	    type: 'link', // 分享类型,music、video或link，不填默认为link
	    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
	    success: function () { 
	        // 用户确认分享后执行的回调函数
	    	//alert("开始");
	    },
	    cancel: function () { 
	        // 用户取消分享后执行的回调函数
	    	//alert("结束");
	    }
	});
    wx.error(function(res){
        // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
        alert("errorMSG:"+JSON.stringify(res));
    });
});

</script>
</head>
<body>
<div data-role="page" id="page1">
  <div data-role="header">
  
     <a href="#" onClick='window.location.href="../sign_up.php?promotionId=<?php echo $id;?>&parentId=<?php echo $userId;?>"' data-role="button">注册会员</a><h1><?php echo $title;?></h1>
     <a href="#" onClick='window.location.href="../sign_up.php?promotionId=<?php echo $id;?>&parentId=<?php echo $userId;?>"' data-role="button">我要报名</a>
     
  </div>

  <div data-role="content">
  <a href="#" onClick='window.location.href="../sign_up.php?promotionId=<?php echo $id;?>&parentId=<?php echo $userId;?>"' data-role="button">了解详情</a>
            <?php echo $content;?>

  </div>

<?php include 'footer.php';?>
</div> 


</body>
</html>
<?php mysql_close($con);?>