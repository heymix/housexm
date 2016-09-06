<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width" /> 
<link rel="stylesheet" href="../jquery/jquery.mobile-1.3.2.min.css">
<script src="../jquery/jquery-1.8.3.min.js"></script>
<script src="../jquery/jquery.mobile-1.3.2.min.js"></script>

<script language="javascript">
$(document).ready(function(){

})

	function submitForm(){
			//alert("ddd");
			

    	if($("#oldPassword").val().length==0){
    		$("#errMsg").html("原密码不能为空！");
     		return false;
         }
        if($("#password").val().length!=6||isNaN($("#password").val())){
        	$("#errMsg").html("新密码为6位纯数字！");
	 		return false;
	     }
	 	if($("#password").val()!=$("#repassword").val()){
	 		$("#errMsg").html("两次输入的密码不相等！");
	 		return false;
	 	}
		$("#errMsg").html('正在提交请稍后....！');
		
			$.post(	"../lib/password_edit.php", 
				$("#editForm").serialize(), 
				function(data,st){
    				var resultArr=data.split("|");
    				$("#errMsg").html(resultArr[1]);
				});
		}
</script>

</head>
<body>

<div data-role="page" id="page1">


<?php include 'header.php';?>

  <div data-role="content">
  <p id="errMsg" style="color:#F00"></p>
  	<form id="editForm" name="editForm"  method="post" >
        原密码: <input type="password" name="oldPassword" id="oldPassword" />
	新密码: <input type="password" name="password" id="password" placeholder="6位数字"/>
	确认密码: <input type="password" name="repassword" id="repassword" placeholder="6位数字" />
    <a href="#" data-role="button" onClick="submitForm();"><img src="../images/add.gif">保存</a>
	</form>
  </div>

<?php include 'footer.php';?>
</div> 


</body>
</html>