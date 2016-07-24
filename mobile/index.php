<?php
if($_GET["action"]=="logout"){
    setcookie("userName", 'null',time() -3600,"/");
    setcookie("userId", 'null',time() -3600,"/");
    setcookie("companyId", 'null',time() -3600,"/");
}
if (isset($_COOKIE["userName"])){
    //重定向浏览器
    header("Location: web/client_list.php");
    exit;
}
?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width" /> 
<link rel="stylesheet" href="jquery/jquery.mobile-1.3.2.min.css">
<script src="jquery/jquery-1.8.3.min.js"></script>
<script src="jquery/jquery.mobile-1.3.2.min.js"></script>
<script language="javascript">
$(document).ready(function(){

})

	function slog(){

			
		if($("#userName").val().length==0){
			$("#errMsg").html('用户名不能为空！');
			return false;
		}
		if($("#userPass").val().length==0){
			$("#errMsg").html('密码不能为空！');
			return false;
		}
		$("#errMsg").html('正在提交请稍后....！');
		
			$.post(	"lib/log_check.php", 
				$("#LogForm").serialize(), 
				function(data,st){
				//alert(data);
    				var resultArr=data.split("|");
    				if(resultArr[0]=="1"){
    					window.location="web/client_list.php";
    				}
    				else{
    					$("#errMsg").html(data);
    				}
						
				});
		}

</script>
</head>
<body>

<div data-role="page" id="page1" data-theme="d">
  <div data-role="header">
    <h1>广嘉汇众地产服务中心</h1>
  </div>

  <div data-role="content">

  
    <p id="errMsg" style="color:#F00"></p>
    <form id="LogForm" name="LogForm"  method="post" >
	用户名: <input type="text" name="userName" id="userName" />
	密码: <input type="password" name="userPass" id="userPass" />
    <a href="#" data-role="button" onClick="slog();"><img src="images/seek.gif"> 登录</a>
	</form>

  </div>

  <div data-role="footer">
  <h1>广嘉汇众</h1>
  </div>
</div> 

</body>
</html>
