<?php 
$action =$_GET["action"];
include '../config/config.php';
mysql_select_db($db_name, $con);          //选择数据库
mysql_query($char_set);
if ($action=="edit"){
 $id=$_GET["id"];    
    if(is_numeric($id)){
        
        $Query = "select * from t_admin where is_del=0 and id=$id";
        $result     = mysql_query($Query);
        $rs     = mysql_fetch_array($result);
        if(!$rs){die("0|Valid result!"); mysql_close($con);}
        $companyId = $rs["company_id"];
        $userName = $rs["user_name"];
        $trueName = $rs["true_name"];
        $userId =$rs["user_id"];
        $sex = $rs["sex"];
        $contact =$rs["contact"];
        $tel =$rs["tel"];
        $remark =$rs["remark"];
       
           
    }else{
        echo "错误:入参非法";
        return false;
    }
    
    
}else{
    $action="save";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理</title>
<link href="../css/main.css" rel="stylesheet" type="text/css" />
<link href="../css/news.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../inc/jquery-1.7.1.min.js"></script>
    <link rel="stylesheet" href="../jquery/base/jquery.ui.all.css">
	<script src="../jquery/ui/jquery.timePicker.js"></script>
	<script src="../jquery/ui/jquery.ui.core.min.js"></script>
	<script src="../jquery/ui/jquery.ui.widget.min.js"></script>
	<script src="../jquery/ui/jquery.ui.datepicker.min.js"></script>
	<script src="../jquery/ui/jquery.ui.datepicker-zh-CN.min.js"></script>
	
	
 <script type="text/javascript">

 $(document).ready(function(e) {
	$(function() {
		$( "#START_TIME" ).datepicker();
		$( "#END_TIME" ).datepicker();
		$( "#CERT_TIME" ).datepicker({dateFormat: "yy"});
		$( "#CHECK_TIME" ).datepicker({changeYear: true});
		
	});
		//table 颜色   
		$(".list_table tr").mouseover(function(){   
	   //如果鼠标移到class为stripe的表格的tr上时，执行函数   
	  		$(this).addClass("over");}).mouseout(function(){   
			//给这行添加class值为over，并且当鼠标一出该行时执行函数   
			$(this).removeClass("over");}) //移除该行的class  

  			$(".list_table tr:even").addClass("alt");
			
			
			
		 $(".list_table tr").click(function(){
			  		
				  if(this.className.indexOf('checkBgColor')<0){
					 	$(this).addClass('checkBgColor');
						$(this).find(":checkbox").attr("checked",true);
				  }
				  else{
					 $(this).removeClass('checkBgColor');
					 $(this).find(":checkbox").attr("checked",false);
				  }
			  });			
				
});



	function resetForm(){
		$('#editForm')[0].reset();
	}
	function submitForm(){
		
			if($("#userName").val()==""){
				alert("用户名不能为空！");
				return false;
			}
			if($("#trueName").val()==""){
				alert("姓名不能为空！");
				return false;
			}


			if($("#password").val()!=$("#repassword").val()){
				alert("两次输入的密码不相等！");
				return false;
			}	
			$.post(	"../lib/admin_edit.php", 
					$("#editForm").serialize(), 
					function(data,st){
							
							var resultArr=data.split("|");
							if(resultArr[0]=="1"){
								alert(resultArr[1]);
								
								window.location.reload();
								resetForm();
							}
							else{
								alert(resultArr[1]);	
							}	
					});
	
	}

</script>
</head>

<body  >
<table  width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="15" height="30"><img src="../images/tab_03.gif" width="15" height="30" /></td>
        <td width="550" background="../images/tab_05.gif" class="tdStyle"><img src="../images/operatePanle.gif" width="16" height="16" /> <span class="tbTitle">操作面板>>添加</span></td>
        <td background="../images/tab_05.gif" class="tdStyle tdNavMn"><img src="../images/seek.gif" width="16" height="16" /><a href="javascript:void(0)" onClick="window.location='admin_list.php'">查询</a> <img src="../images/001.gif" width="14" height="14" /><a href="javascript:void(0)" onClick="resetForm();">添加记录</a></td>
        <td width="14"><img src="../images/tab_07.gif" width="14" height="30" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="9" background="../images/tab_12.gif">&nbsp;</td>
        <td bgcolor="#f3ffe3"  class="tdStyle"><form method="post" id="editForm" name="editForm"  title="学校管理" >
        <input id="action" name="action" value="<?php echo $action?>" type=hidden>
        <input id="id" name="id" value="<?php echo $id?>" type=hidden>
<label style="width:120px"><span></span> 编号：</label><input disabled type="text"  style="width:200px" value="<?php echo $id?>"></br>
<label style="width:120px"><span>*</span> 用户名：</label><input <?php if($action=="edit") echo "disabled"; ?> type="text" id="userName" name="userName" style="width:200px" value="<?php echo $userName;?>"></br>
<label style="width:120px"><span ><?php if($action=="edit") {echo "不改,留空";} else {echo "*";} ?></span> 密码：</label><input type="password" id="password" name="password" style="width:200px" value=""></br>
<label style="width:120px"><span></span> 确认密码：</label><input type="password" id="repassword" name="repassword" style="width:200px" value=""></br>

<label style="width:120px"><span></span> 公司：</label>
<select id="companyId" name="companyId">
	<?php 
	echo"<option value='-1' ".$selected.">系统管理员</option>\n";
	$q = "select * from t_company where is_del=0  order by pinyin_name asc";                   //SQL查询语句
	mysql_query($char_set);
	$rs = mysql_query($q, $con);                     //获取数据集
	//echo $q;
	if(!$rs){die("Valid result!");}
	
	$i=0;
	while($row = mysql_fetch_array($rs)) {
	    if($row['id']==$companyId){
	        $selected="selected";
	    }else{
	        $selected="";
	    }
	    echo"<option value='".$row['id']."' ".$selected.">".$row['name']."</option>\n";
	}
	?>
	
   <?php ?>
</select></br>
<label style="width:120px"><span></span>　备注：</label><textarea id="remark" name="remark" ><?php echo $remark?></textarea></br>
<br/>
<br/>
<br/>
<br/><br/>

   
    
            <div  class="suggestionsMain" style="text-align:right">
 					<img src="../images/005.gif" width="14" height="14" />[<a id="submitLink" href="javascript:void(0)" onClick="submitForm();">提交数据</a>] <img src="../images/002.gif" width="14" height="14"/>[<a href="javascript:void(0)" onClick="resetForm();">重置</a>]
              </div>
   
        </form></td>
        <td width="9" background="../images/tab_16.gif">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="29"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="15" height="29"><img src="../images/tab_20.gif" width="15" height="29" /></td>
        <td background="../images/tab_21.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td  height="29" >&nbsp;</td>
          </tr>
        </table></td>
        <td width="14"><img src="../images/tab_22.gif" width="14" height="29" /></td>
      </tr>
    </table></td>
  </tr>
</table>
<!--本页面执行时间：-36,488,730.000毫秒-->

</body>
</html>
<?php  mysql_close($con);?>
