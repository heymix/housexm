<?php 
    $parentId=$_GET["parentId"];
    $promotionId=$_GET["promotionId"];
?>
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
  	
        	if($("#name").val()==""){
        		alert("姓名不能为空！");
        		return false;
        	}
        
			if($("#tel").val().length==0){
				alert('手号码不能为空！');
				return false;
			}

		$("errMsg").html('正在提交请稍后....！');
		
			$.post(	"lib/sign_up.php", 
				$("#editForm").serialize(), 
				function(data,st){
    				var resultArr=data.split("|");
    				alert(resultArr[1]);
				});
		}
</script>

</head>
<body>

<div data-role="page" id="page1">


   <div data-role="header">
   <h1>广嘉汇众地产服务中心</h1><a href="#" onClick="submitForm();" data-role="button">保存</a>
  </div>

  <div data-role="content">
  <p id="errMsg" style="color:#F00"></p>
  <form id="editForm" name="editForm"  method="post" >
  <input id="action" name="action" value="save" type=hidden>
	姓名: <input type="text" name="name" id="name" />
	电话: <input type="text" name="tel" id="tel" />
    <input type="hidden" name="promotionId" id="promotionId" value="<?php echo $promotionId;?>" />
	<input type="hidden" name="parentId" id="parentId" value="<?php echo $parentId;?>" />
    <a href="#" data-role="button" onClick="submitForm();"><img src="../images/add.gif">提交</a>
	</form>
  </div>

<div data-role="footer">
  <h1>广嘉汇众</h1>
  </div>
</div> 


</body>
</html>
