<?php include '../config/config.php';

$name = $_GET["name"];
$id = $_GET["id"];
$tel = $_GET["tel"];

$checkTimeStart = $_GET["checkTimeStart"];
$checkTimeEnd = $_GET["checkTimeEnd"];
$endPriceTimeStart = $_GET["endPriceTimeStart"];
$endPriceTimeEnd = $_GET["endPriceTimeEnd"];

$employeeTel = $_GET["employeeTel"];
$checkStatus = $_GET["checkStatus"];
$housePrice = $_GET["housePrice"];
$companyName = $_GET["companyName"];
$trueName = $_GET["trueName"];
$projectName = $_GET["projectName"];
$priceStatus = $_GET["priceStatus"];


$Page_size = 10;

mysql_select_db($db_name, $con);          //选择数据库
mysql_query($char_set);

$sqlKey="";
$searchStr = $_SERVER["QUERY_STRING"];

if (strpos($searchStr,"&")>0){
    $searchStr= substr($searchStr,strpos($searchStr,"&"),strlen($searchStr));
}else{
    $searchStr="";
}

if ($name!=""){
    $sqlKey .= " and t.`name` like '%$name%'";
}
if ($id!=""){
    $sqlKey .= " and t.`id` = '$id'";
}

if ($tel!=""){
    $sqlKey .= " and t.`tel`like '%$tel%'";
}

if ($checkTimeStart!=""){
    $sqlKey .= " and t.`check_time` >= DATE_FORMAT('$checkTimeStart','%Y-%m-%d 00:00:00')";
}

if ($checkTimeEnd!=""){
    $sqlKey .= " and t.`check_time` <= DATE_FORMAT('$checkTimeEnd','%Y-%m-%d 00:00:00')";
}

if ($endPriceTimeStart!=""){
    $sqlKey .= " and t.`end_price_time` >= DATE_FORMAT('$endPriceTimeStart','%Y-%m-%d 00:00:00')";
}

if ($endPriceTimeEnd!=""){
    $sqlKey .= " and t.`end_price_time` <= DATE_FORMAT('$endPriceTimeEnd','%Y-%m-%d 00:00:00')";
}



if($checkStatus!=""){
    $sqlKey .= " and t.`check_status` = '$checkStatus'";
}
if($priceStatus!=""){
    $sqlKey .= " and t.`price_status` = '$priceStatus'";
}

if($trueName!=""){
    $sqlKey .= " and e.`true_name` like '%$trueName%'";
}

if($companyName!=""){
    $sqlKey .= " and c.`name` like '%$companyName%'";
}

if($projectName!=""){
    $sqlKey .= " and p.`name` like '%$projectName%'";
}

if($employeeTel!=""){
    $sqlKey .= " and e.`tel` like '%$employeeTel%'";
}


if($_SESSION['channel'] == "1"){

    if(checkPower("20")){
        $sqlKey .= " and e.`company_id` = '".$_SESSION['companyId']."'";
    }

}else{

    if(checkPower("20")){
        $sqlKey .= " and e.`company_id` = '".$_SESSION['companyId']."'";
        $sqlKey .= " and t.`employee_id` = '".$_SESSION['userId']."'";
    }
}


$Query = "Select count(*) as c from  t_client as t 
left join t_project as p on t.project_id=p.id
left join t_employee as e on t.employee_id=e.id 
left join t_company as c on e.company_id=c.id
left join t_dictionary as d_ps on t.price_status=d_ps.value and d_ps.type='price_status'
left join t_dictionary as d_checks on t.check_status=d_checks.value and d_checks.type='check_status'
where t.is_del=0 $sqlKey";

$result     = mysql_query($Query);
$rs     = mysql_fetch_array($result);
$count = $rs["c"]; //条数


$page_count = ceil($count / $Page_size);

$init = 1;
$page_len = 7;
$max_p = $page_count;
$pages = $page_count;

// 判断当前页码
if (empty($_GET['page']) || $_GET['page'] < 0) {
    $page = 1;
} else {
    $page = $_GET['page'];
}

$offset = $Page_size * ($page - 1);
$sql = "SELECT t.*,p.name as project_name,e.user_name,e.true_name,e.tel as employee_tel,c.name as company_name,d_ps.name as price_status_name
,d_checks.name as check_status_name
FROM t_client as t 
left join t_project as p on t.project_id=p.id
left join t_employee as e on t.employee_id=e.id 
left join t_company as c on e.company_id=c.id
left join t_dictionary as d_ps on t.price_status=d_ps.value and d_ps.type='price_status'
left join t_dictionary as d_checks on t.check_status=d_checks.value and d_checks.type='check_status'
            where t.is_del=0 $sqlKey order by t.id desc limit $offset,$Page_size";
//echo $sql;
$result = mysql_query($sql);
$content="";
while ($row = mysql_fetch_array($result)) {
$content.="<tr>\n";
$content.="    <td height='18' ><div align='center' >\n";
$content.="    <input name='subBox[]' type='checkbox' value='".$row['id']."' />\n";
$content.="    </div></td>\n";
$content.="    <td height='18' ><span class='tdStyle'>".$row['project_name']."</span></td>\n";
$content.="    <td height='18' >".$row['name']."(".$row['id'].")</td>\n";
$content.="    <td height='18' >".$row['tel']."</td>\n";
$content.="    <td height='18' >".$row['company_name']."</td>\n";
$content.="    <td height='18' >".$row['true_name']."(".$row['user_name'].")</td>\n";
$content.="    <td height='18' >".$row['employee_tel']."</td>\n";
if(!empty($row['create_time'])){
    $create_time=date("Y-m-d",strtotime($row['create_time']));
}else{
    $create_time="";
}
$content.="    <td height='18' >".$create_time."</td>\n";
if(!empty($row['check_time'])){
    $check_time=date("Y-m-d",strtotime($row['check_time']));
}else{
    $check_time="";
} 
$content.="    <td height='18' >". $check_time ."</td>\n";
$content.="    <td height='18' >".$row['house_price']."</td>\n";
$content.="    <td height='18' >".$row['area']."</td>\n";
$content.="    <td height='18' >".$row['num']."</td>\n";
$content.="    <td height='18' >".$row['price']."</td>\n";
$content.="    <td height='18' >".$row['price_status_name']."</td>\n";

if(!empty($row['end_price_time'])){
    $end_price_time=date("Y-m-d",strtotime($row['end_price_time']));
}else{
    $end_price_time="";
}

$content.="    <td height='18' >". $end_price_time ."</td>\n";
$content.="    <td height='18' >".$row['remark']."</td>\n";
$editStr="";
if(checkPower("21")){
    $editStr="<img src='../images/edit.gif'>[<a href=\"client_edit.php?id=".$row['id']."&action=edit\">编辑</a>]";
}
$content.="    <td height='18'>$editStr<img src='../images/edit.gif'>[<a href=\"employee_tree.php?id=".$row['employee_id']."&action=edit\">关系树</a>]</td>";
$content.="</tr>\n";
}
$page_len = ($page_len % 2) ? $page_len : $pagelen + 1; // 页码个数
$pageoffset = ($page_len - 1) / 2; // 页码个数左右偏移量

$key = '<div class="page">';
$key .= "<span>$page/$pages</span> "; // 第几页,共几页
if ($page != 1) {
    $key .= "<a href=\"" . $_SERVER['PHP_SELF'] . "?page=1$searchStr\">第一页</a> "; // 第一页
    $key .= "<a href=\"" . $_SERVER['PHP_SELF'] . "?page=" . ($page - 1) . "$searchStr\">上一页</a>"; // 上一页
} else {
    $key .= "第一页 "; // 第一页
    $key .= "上一页"; // 上一页
}
if ($pages > $page_len) {
    // 如果当前页小于等于左偏移
    if ($page <= $pageoffset) {
        $init = 1;
        $max_p = $page_len;
    } else { // 如果当前页大于左偏移
           // 如果当前页码右偏移超出最大分页数
        if ($page + $pageoffset >= $pages + 1) {
            $init = $pages - $page_len + 1;
        } else {
            // 左右偏移都存在时的计算
            $init = $page - $pageoffset;
            $max_p = $page + $pageoffset;
        }
    }
}
for ($i = $init; $i <= $max_p; $i ++) {
    if ($i == $page) {
        $key .= ' <span>' . $i . '</span>';
    } else {
        $key .= " <a href=\"" . $_SERVER['PHP_SELF'] . "?page=" . $i . "$searchStr\">" . $i . "</a>";
    }
}
if ($page < $pages) {
    $key .= " <a href=\"" . $_SERVER['PHP_SELF'] . "?page=" . ($page + 1) . "$searchStr\">下一页</a> "; // 下一页
    $key .= "<a href=\"" . $_SERVER['PHP_SELF'] . "?page={$pages}$searchStr\">最后一页</a>"; // 最后一页
} else {
    $key .= "下一页 "; // 下一页
    $key .= "最后一页"; // 最后一页
}
$key .= '</div>';


?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>销售管理</title>
<link href="../css/main.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../inc/jquery-1.7.1.min.js"></script>
<script src="../jquery/jquery.bgiframe.min.js" type="text/javascript" charset='utf-8'></script>
<script src="../jquery/loading-min.js" type="text/javascript"  charset="UTF-8"></script>

    <link rel="stylesheet" href="../jquery/base/jquery.ui.all.css">
	<script src="../jquery/ui/jquery.timePicker.js"></script>
	<script src="../jquery/ui/jquery.ui.core.min.js"></script>
	<script src="../jquery/ui/jquery.ui.widget.min.js"></script>
	<script src="../jquery/ui/jquery.ui.datepicker.min.js"></script>
	<script src="../jquery/ui/jquery.ui.datepicker-zh-CN.min.js"></script>

 <script type="text/javascript">
 $(document).ready(function(e) {
    loading=new ol.loading({id:"tablePanel"});

    $(function() {
		$( "#checkTimeStart" ).datepicker();
		$( "#checkTimeEnd" ).datepicker();
		$( "#endPriceTimeStart" ).datepicker();
		$( "#endPriceTimeEnd" ).datepicker();
	});
	 $("#checkAll").click(function() {
	  $('input[name="subBox[]"]').attr("checked",this.checked); 
  });
  var $subBox = $("input[name='subBox']");
  $subBox.click(function(){
	  $("#checkAll").attr("checked",$subBox.length == $("input[name='subBox[]']:checked").length ? true : false);
  });
  
  		 $("#inverse").click(function () {//反选
                $("#listForm :checkbox").each(function () {
                    $(this).attr("checked", !$(this).attr("checked"));
                });
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

function searchPost(){
	window.location.href="?1=1&"+$("#searchForm").serialize();	
}

 
function delPost(id,type){

	if(!confirm("确认删除数据吗? 不可恢复...")) return false;

	if(type=="multi"){
		var n = $("#listForm input:checked").length;
		if (n == 0) {
			alert("未选择数据,无法操作！");
			return false;
		}
		loading.show();
		$.post(	"../lib/client_edit.php", 
				$("#listForm").serialize(), 
				function(data,st){
						
						var resultArr=data.split("|");
						if(resultArr[0]=="1"){
							alert(resultArr[1]);
							window.location.reload();
						}
						else{
							alert(resultArr[1]);
							loading.hide();
						}	
				});
		
	}	
}
</script>


</head>

<body >
<table  width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="15" height="30"><img src="../images/tab_03.gif" width="15" height="30" /></td>
        <td width="550" background="../images/tab_05.gif" class="tdStyle"><img src="../images/operatePanle.gif" width="16" height="16" /> <span class="tbTitle">操作面板>>管理</span></td>
        <td background="../images/tab_05.gif" class="tdStyle tdNavMn"></td>
        <td width="14"><img src="../images/tab_07.gif" width="14" height="30" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="9" background="../images/tab_12.gif">&nbsp;</td>
        <td bgcolor="#f3ffe3"  class="tdStyle"><form method="post" id="searchForm" name="searchForm" style="line-height:28px" >
        <label style="width:120px"><span ></span>  客户名：</label><input type="text" id="name" name="name" style="width:200px" value="<?php echo $name?>"> 
        <label style="width:120px"><span ></span>  客户编号：</label><input type="text" id="id" name="id" style="width:200px" value="<?php echo $id?>"> 
        	<label style="width:120px"><span ></span> 客户电话：</label><input type="text" id="tel" name="tel" style="width:200px" value="<?php echo $tel?>"> <br> 
        	<label style="width:120px"><span ></span> 公司名：</label><input type="text" id="companyName" name="companyName" style="width:200px" value="<?php echo $companyName?>"> 
        	<label style="width:120px"><span ></span> 经纪人名称：</label><input type="text" id="trueName" name="trueName" style="width:200px" value="<?php echo $trueName?>">
        	<label style="width:120px"><span ></span> 经纪人电话 ：</label><input type="text" id="employeeTel" name="employeeTel" style="width:200px" value="<?php echo $employeeTel?>"></br>
        	<label style="width:120px"><span></span> 签约状态 ：</label>
<select id="checkStatus" name="checkStatus">
<option value="">请选择</option>
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
</select>
       <label style="width:120px"><span ></span> 签约时间：</label><input type="text" id="checkTimeStart" name="checkTimeStart" style="width:200px" value="<?php echo $checkTimeStart?>"> - <input type="text" id="checkTimeEnd" name="checkTimeEnd" style="width:200px" value="<?php echo $checkTimeEnd?>"></br>
       <label style="width:120px"><span></span> 结佣状态 ：</label>
<select id="priceStatus" name="priceStatus">
<option value="">请选择</option>
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
</select>
       <label style="width:120px"><span ></span> 结佣时间 ：</label><input type="text" id="endPriceTimeStart" name="endPriceTimeStart" style="width:200px" value="<?php echo $endPriceTimeStart?>"> - <input type="text" id="endPriceTimeEnd" name="endPriceTimeEnd" style="width:200px" value="<?php echo $endPriceTimeEnd?>"> <img src="../images/g_page.gif" width="14" height="14" /> 
        <a href="javascript:void(0)" onClick="searchPost();">查询</a></form></td>
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


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tbody><tr>
    <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tbody><tr>
        <td width="15" height="30"><img src="../images/tab_03.gif" width="15" height="30"></td>
        <td width="275" background="../images/tab_05.gif" class="tdStyle"><img src="../images/311.gif" width="16" height="16"> <span class="tbTitle">销售列表</span></td>
        <td background="../images/tab_05.gif" class="tdStyle tdNavMn"><?php if(checkPower("21")){?><a href="javascript:void(0)" onclick="window.location.reload();"><img src="../images/refresh.gif" width="16" height="16"></a>
          <input id="checkAll" type="checkbox" name="checkbox62" value="checkbox" onblur="selectAll(this);">
          全选
          <input id="inverse" type="checkbox" name="inverse" value="checkbox">
          反选  <img src="../images/083.gif" width="14" height="14"><font><a href="javascript:void(0)" onclick="delPost('-1','multi');">删除选中</a></font><?php }?> </td>
        <td width="14"><img src="../images/tab_07.gif" width="14" height="30"></td>
      </tr>
    </tbody></table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tbody><tr>
        <td width="9" background="../images/tab_12.gif">&nbsp;</td>
        <td bgcolor="#f3ffe3"><form id="listForm" name="listForm" method="post">
    		<input id="action" name="action" value="del" type="hidden">
          <table class="list_table" width="99%" border="0" align="center" cellpadding="0" cellspacing="1">
            <tbody><tr class="alt">
              <th height="26">选择</th>
              <th  height="26">项目名称</th>
              <th height="26">客户姓名(编号)</th>
              <th height="26">客户电话</th>
              <th  height="26">公司</th>
              <th height="26">经纪人姓名(用户名)</th>
              <th  height="26">经纪人电话</th>
              <th height="26">录入时间</th>
              <th  height="26">签约时间</th>
              <th  height="26">金额</th>
              <th  height="26">面积</th>
               <th  height="26">房号</th>
               <th height="26">佣金金额</th>
               <th  height="26">佣金状态</th>
               <th  height="26">结佣时间</th>
              <th  height="26">备注</th>
              <th height="26">操作</th>
              </tr>
           
       <?php echo $content?>
            
          </tbody></table>
        </form></td>
        <td width="9" background="../images/tab_16.gif">&nbsp;</td>
      </tr>
    </tbody></table></td>
  </tr>
  <tr>
    <td height="29"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tbody><tr>
        <td width="15" height="29"><img src="../images/tab_20.gif" width="15" height="29"></td>
        <td background="../images/tab_21.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tbody><tr>
            <td height="29" id="bNavStr"><table id="pageNav" bordercolor="#111111" height="10" cellspacing="0" cellpadding="0" width="100%" border="0"><tbody><tr><td><?php echo $key?></td></tr></tbody></table></td>
          </tr>
        </tbody></table></td>
        <td width="14"><img src="../images/tab_22.gif" width="14" height="29"></td>
      </tr>
    </tbody></table></td>
  </tr>
</tbody></table>
<!--本页面执行时间：-76,368,170.000毫秒-->
</body>
</html>
<?php mysql_close($con);?>