<?php include '../config/config.php';

$userName=$_GET['userName'];
$companyName=$_GET['companyName'];
$tel=$_GET['tel'];
$remark=$_GET['remark'];


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
if ($userName!=""){
    $sqlKey .= " and e.`user_name` like '%$userName%'";
}
if($companyName!=""){
    $sqlKey .= " and c.`name` like '%$companyName%'";
}
if($tel!=""){
    $sqlKey .= " and c.`tel` like '%$tel%'";
}
if($remark!=""){
    $sqlKey .= " and c.`remark` like '%$remark%'";
}



$Query = "Select count(*) as c from t_admin where is_del=0 $sqlKey";
$result     = mysql_query($Query);
$rs     = mysql_fetch_array( $result );
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
$sql = "select e.*,c.name as company_name,c.tel as tel from t_admin e left join t_company c on e.company_id=c.id 
            where e.is_del=0 $sqlKey order by e.id desc limit $offset,$Page_size";
$result = mysql_query($sql);
$content="";
while ($row = mysql_fetch_array($result)) {

$content.="<tr>\n";
$content.="    <td height='18' ><div align='center' >\n";
$content.="    <input name='subBox[]' type='checkbox' value='".$row['id']."' />\n";
$content.="    </div></td>\n";
$content.="    <td height='18' >".$row['user_name']."</td>\n";
$content.="    <td height='18' >".$row['company_name']."</td>\n";
$content.="    <td height='18' >".$row['tel']."</td>\n";
$content.="    <td height='18' >".$row['remark']."</td>\n";
$content.="    <td height='18'><img src='../images/edit.gif'>[<a href=\"admin_edit.php?id=".$row['id']."&action=edit\">编辑</a>]</td>";
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

mysql_close($con);
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>公司管理</title>
<link href="../css/main.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../inc/jquery-1.7.1.min.js"></script>
<script src="../jquery/jquery.bgiframe.min.js" type="text/javascript" charset='utf-8'></script>
<script src="../jquery/loading-min.js" type="text/javascript"  charset="UTF-8"></script>

 <script type="text/javascript">
 $(document).ready(function(e) {
    loading=new ol.loading({id:"tablePanel"});

	
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
		$.post(	"../lib/admin_edit.php", 
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
        <td background="../images/tab_05.gif" class="tdStyle tdNavMn"><img src="../images/001.gif" width="14" height="14" /><a href="admin_edit.php" >添加</a></td>
        <td width="14"><img src="../images/tab_07.gif" width="14" height="30" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="9" background="../images/tab_12.gif">&nbsp;</td>
        <td bgcolor="#f3ffe3"  class="tdStyle"><form method="post" id="searchForm" name="searchForm" style="line-height:28px" >
        <label style="width:120px"><span ></span> 用户名：</label><input type="text" id="userName" name="userName" style="width:200px" value="<?php echo $userName?>"> 
        	<label style="width:120px"><span ></span> 公司：</label><input type="text" id="companyName" name="companyName" style="width:200px" value="<?php echo $companyName?>">
        	<label style="width:120px"><span ></span> 电话：</label><input type="text" id="tel" name="tel" style="width:200px" value="<?php echo $tel?>">
        	<label style="width:120px"><span ></span> 备注：</label><input type="text" id="remark" name="remark" style="width:200px" value="<?php echo $remark?>"> <img src="../images/g_page.gif" width="14" height="14" /> 
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
        <td width="275" background="../images/tab_05.gif" class="tdStyle"><img src="../images/311.gif" width="16" height="16"> <span class="tbTitle">管理员列表</span></td>
        <td background="../images/tab_05.gif" class="tdStyle tdNavMn"><a href="javascript:void(0)" onclick="window.location.reload();"><img src="../images/refresh.gif" width="16" height="16"></a>
          <input id="checkAll" type="checkbox" name="checkbox62" value="checkbox" onblur="selectAll(this);">
          全选
          <input id="inverse" type="checkbox" name="inverse" value="checkbox">
          反选  <img src="../images/083.gif" width="14" height="14"><font><a href="javascript:void(0)" onclick="delPost('-1','multi');">删除选中</a></font> </td>
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
              <th width="5%" height="26">选择</th>
              <th width="10%" height="26">用户名</th>
              <th width="10%" height="26">公司</th>
              <th width="10%" height="26">电话</th>
              <th width="15%" height="26">备注</th>
              <th width="5%" height="26">操作</th>
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
