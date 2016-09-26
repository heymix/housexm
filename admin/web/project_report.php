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





if ($endPriceTimeStart!=""){
    $sqlKey .= " and t.`end_price_time` >= DATE_FORMAT('$endPriceTimeStart','%Y-%m-%d 00:00:00')";
}

if ($endPriceTimeEnd!=""){
    $sqlKey .= " and t.`end_price_time` <= DATE_FORMAT('$endPriceTimeEnd','%Y-%m-%d 00:00:00')";
}



$yjKey="";
if($priceStatus!=""){
    $sqlKey .= " and t.`price_status` = '$priceStatus'";
    if($priceStatus==1){
        $yjKey .= " and (yj.`price_status` = 1 or yj.`price_status` is null)";
    }
    
    if($priceStatus==2){
        $yjKey .= " and yj.`price_status` = 2 ";
    }
    
}


if($projectName!=""){
    $sqlKey .= " and p.`name` like '%$projectName%'";
}


if($_SESSION['channel'] == "1"){

    if(checkPower("27")){
        $sqlKey .= " and e.`company_id` = '".$_SESSION['companyId']."'";
    }

}else{

    if(checkPower("27")){
        $sqlKey .= " and e.`company_id` = '".$_SESSION['companyId']."'";
        $sqlKey .= " and (e.`id` = '". $_SESSION['userId']."' or e.`parent_id` = '".$_SESSION['userId']."')";
    }
}


$Query = "Select count(*) as c from (SELECT t.id FROM t_client as t 
left join t_project as p on p.id=t.project_id 
left join t_employee as e on t.employee_id=e.id 
where t.is_del=0 $sqlKey group by t.project_id) as t";
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
$sql = "SELECT sum(price) as price_sum,p.name as project_name
,(select count(*) from t_client as yj where yj.project_id=t.project_id and yj.price_status=2 $yjKey) as price_status_is
,(select count(*) from t_client as yj where yj.project_id=t.project_id and (yj.price_status=1 or yj.price_status is null) $yjKey) as price_status_not
FROM t_client as t 
left join t_project as p on p.id=t.project_id
left join t_employee as e on t.employee_id=e.id  
where t.is_del=0 $sqlKey group by t.project_id limit $offset,$Page_size";
//echo $sql;
$result = mysql_query($sql);
$content="";
while ($row = mysql_fetch_array($result)) {
$content.="<tr>\n";
$content.="    <td height='18' ><div align='center' >\n";
$content.="    <input name='subBox[]' type='checkbox' value='".$row['id']."' />\n";
$content.="    </div></td>\n";
$content.="    <td height='18' ><span class='tdStyle'>".$row['project_name']."</span></td>\n";
$content.="    <td height='18' >".$row['price_sum']."</td>\n";
$content.="    <td height='18' >".$row['price_status_is']."</td>\n";
$content.="    <td height='18' >".$row['price_status_not']."</td>\n";
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
<title>客户统计</title>
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

 
function exportExcel(){
	if(!confirm("确认导出数据吗？")) return false;
	window.location.href="project_report_export.php?1=1&"+$("#searchForm").serialize();
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
        <label style="width:120px"><span ></span>  项目名称：</label><input type="text" id="projectName" name="projectName" style="width:200px" value="<?php echo $projectName;?>"> 
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
        <td width="275" background="../images/tab_05.gif" class="tdStyle"><img src="../images/311.gif" width="16" height="16"> <span class="tbTitle">项目信息报表</span></td>
        <td background="../images/tab_05.gif" class="tdStyle tdNavMn"><img src="../images/excel.gif" alt="导出" /><a href="#" onclick="exportExcel();">导出excel</a> </td>
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
              <th height="26">佣金</th>
              <th  height="26">已结</th>
              <th  height="26">未结</th>
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