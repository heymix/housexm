<?php 
$action =$_GET["action"];
include '../config/config.php';
mysql_select_db($db_name, $con);          //选择数据库
mysql_query($char_set);
if ($action=="edit"){
 $id=$_GET["id"];    
    if(is_numeric($id)){
        
        $Query = "SELECT t.*,p.name as project_name,e.user_name,e.true_name,e.tel as employee_tel,c.name as company_name,d_ps.name as price_status_name
            ,d_checks.name as check_status_name
            FROM t_client as t 
            left join t_project as p on t.project_id=p.id
            left join t_employee as e on t.employee_id=e.id 
            left join t_company as c on e.company_id=c.id
            left join t_dictionary as d_ps on t.price_status=d_ps.value and d_ps.type='price_status'
            left join t_dictionary as d_checks on t.check_status=d_checks.value and d_checks.type='check_status'
                        where t.is_del=0 and t.id=$id";
        $result     = mysql_query($Query);
        $row     = mysql_fetch_array($result);
        if(!$row){die("0|Valid result!"); mysql_close($con);}
        
        $projectName = $row['project_name'];
        $name = $row['name'];
        $tel = $row['tel'];
        $companyName = $row['company_name'];
        $trueName = $row['true_name']."(".$row['user_name'].")";
        $employeeTel = $row['employee_tel'];
        $checkStatus = $row['check_status'];
        $checkTime = $row['check_time'];
        $housePrice = $row['house_price'];
        $area=$row['area'];
        $num=$row['num'];
        $price=$row['price'];
        $priceStatus=$row['price_status'];
        $endPriceTime=$row['end_price_time'];
        $visitDate=$row['visit_date'];
        $remark=$row['remark'];
 
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
		$("#checkTime" ).datepicker();
		$("#endPriceTime" ).datepicker();
		$("#visitDate" ).datepicker();
		
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
		
			if($("#name").val()==""){
				alert("项目名称不能为空！");
				return false;
			}
					
			$.post(	"../lib/client_edit.php", 
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
        <td background="../images/tab_05.gif" class="tdStyle tdNavMn"><img src="../images/seek.gif" width="16" height="16" /><a href="javascript:void(0)" onClick="window.location='client_list.php'">查询</a> <img src="../images/001.gif" width="14" height="14" /><a href="javascript:void(0)" onClick="resetForm();">添加记录</a></td>
        <td width="14"><img src="../images/tab_07.gif" width="14" height="30" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
  
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="9" background="../images/tab_12.gif">&nbsp;</td>
        <td bgcolor="#f3ffe3"  class="tdStyle"><form method="post" id="editForm" name="editForm"  title="管理" >
        <input id="action" name="action" value="<?php echo $action?>" type=hidden>
        <input id="id" name="id" value="<?php echo $id?>" type=hidden>
<label style="width:120px"><span></span> 项目名称：</label><input disabled type="text"   value="<?php echo $projectName?>"></br>
<label style="width:120px"><span>*</span>客户名称(编号)：</label><input disabled type="text" style="width:200px" value="<?php echo $name."($id)";?>"></br>
<label style="width:120px"><span></span> 经纪人名称(电话)：</label><input disabled type="text"  style="width:200px" value="<?php echo $trueName."($employeeTel)"?>"></br>
<label style="width:120px"><span>*</span> 公司：</label><input disabled type="text" style="width:200px" value="<?php echo $companyName?>"></br>

<label style="width:120px"><span></span> 签约时间：</label><input type="text" id="checkTime" name="checkTime"   style="width:200px" value="<?php if(!empty($checkTime)) echo date("Y-m-d",strtotime($checkTime));?>"></br>
<label style="width:120px"><span></span> 签约状态：</label>
<select id="checkStatus" name="checkStatus">
    <option value="0">请选择</option>
	<?php 
	$q = "select * from t_dictionary where type='check_status' order by order_id asc";                   //SQL查询语句
	mysql_query($char_set);
	$rs = mysql_query($q, $con);                     //获取数据集
	//echo $q;
	if(!$rs){die("Valid result!");}
	
	$i=0;
	while($row = mysql_fetch_array($rs)) {
	    if($row['value']==$checkStatus){
	        $selected="selected";
	    }else{
	        $selected="";
	    }
	    echo"<option value='".$row['value']."' ".$selected.">".$row['name']."</option>\n";
	}
	?>
	
   <?php ?>
</select></br>
<label style="width:120px"><span></span> 金额：</label><input type="text" id="housePrice" name="housePrice"   style="width:200px" value="<?php echo $housePrice?>"></br>
<label style="width:120px"><span></span> 面积：</label><input type="text" id="area" name="area"   style="width:200px" value="<?php echo $area?>"></br>
<label style="width:120px"><span></span> 房号：</label><input type="text" id="num" name="num"   style="width:200px" value="<?php echo $num?>"></br>
<label style="width:120px"><span></span> 佣金：</label><input type="text" id="price" name="price"   style="width:200px" value="<?php echo $price?>"></br>
<label style="width:120px"><span></span> 佣金状态：</label>
<select id="priceStatus" name="priceStatus">
    <option value="0">请选择</option>
	<?php 
	$q = "select * from t_dictionary where type='price_status' order by order_id asc";                   //SQL查询语句
	mysql_query($char_set);
	$rs = mysql_query($q, $con);                     //获取数据集
	//echo $q;
	if(!$rs){die("Valid result!");}
	
	$i=0;
	while($row = mysql_fetch_array($rs)) {
	    if($row['value']==$priceStatus){
	        $selected="selected";
	    }else{
	        $selected="";
	    }
	    echo"<option value='".$row['value']."' ".$selected.">".$row['name']."</option>\n";
	}
	?>
	
   <?php ?>
</select></br>

<label style="width:120px"><span></span> 结佣时间：</label><input type="text" id="endPriceTime" name="endPriceTime"   style="width:200px" value="<?php if(!empty($endPriceTime)) echo date("Y-m-d",strtotime($endPriceTime));?>"></br>
<label style="width:120px"><span></span> 来访时间：</label><input type="text" id="visitDate" name="visitDate"   style="width:200px" value="<?php if(!empty($visitDate)) echo date("Y-m-d",strtotime($visitDate));?>"></br></br>
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
