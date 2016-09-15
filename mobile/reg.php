<?php 
include 'config/conn.php';
$parentId=$_GET["parentId"];
mysql_select_db($db_name, $con);          //选择数据库
mysql_query($char_set);
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
			//alert("ddd");
			

        	if($("#userName").val()==""){
        		alert("用户名不能为空！");
        		return false;
        	}
        	if($("#trueName").val()==""){
        		alert("姓名不能为空！");
        		return false;
        	}
        
  
			if($("#tel").val().length==0){
				alert('手号码不能为空！');
				return false;
			}
			 if($("#password").val().length!=6||isNaN($("#password").val())){
            	alert("密码为6位纯数字！");
        		return false;
            }
        	if($("#password").val()!=$("#repassword").val()){
        		alert("两次输入的密码不相等！");
        		return false;
        	}
		
        	$("#errMsg").html('正在提交请稍后....！');
		
			$.post(	"lib/reg_insert.php", 
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
    <a href="#" onClick="window.location.href='index.php'" data-role="button">登录</a><h1>广嘉汇众地产服务中心</h1><a href="#" onClick="submitForm();" data-role="button">保存</a>
  </div>

  <div data-role="content">
  <p id="errMsg" style="color:#F00"></p>
  	<form id="editForm" name="editForm"  method="post" >
  	选择公司: <select <?php if($action=='edit') echo "disabled";?>  name="companyId" id="companyId">
  	      <?php 
        	$q = "select * from t_company where is_del=0 order by pinyin_name asc";                   //SQL查询语句
        	mysql_query($char_set);
        	$rs = mysql_query($q, $con);                     //获取数据集
        	//echo $q;
        	if(!$rs){die("Valid result!");}
        	
        	$i=0;
        	while($row = mysql_fetch_array($rs)) {
        	    if($row['id']==$projectId){
        	        $selected="selected";
        	    }else{
        	        $selected="";
        	    }
        	    echo"<option value='".$row['id']."' ".$selected.">".$row['name']."</option>\n";
        	}
        	?>
  </select>
  <input id="action" name="action" value="<?php echo $action?>" type=hidden>
        用户名: <input type="text" name="userName" id="userName" />
	姓名: <input type="text" name="trueName" id="trueName" />
	电话: <input type="text" name="tel" id="tel" />
	微信: <input type="text" name="wechat" id="wechat" />
	推荐码: <input <?php if(!empty($parentId)) echo ""?> type="text" name="parentId" id="parentId" value="<?php echo$parentId;?>" />
	密码: <input type="password" name="password" id="password" placeholder="6位数字"/>
	确认密码: <input type="password" name="repassword" id="repassword" placeholder="6位数字" />
    <a href="#" data-role="button" onClick="submitForm();"><img src="../images/add.gif">提交</a>
	</form>
  </div>

<div data-role="footer">
  <h1>广嘉汇众</h1>
  </div>
</div> 


</body>
</html>
<?php mysql_close($con);?>