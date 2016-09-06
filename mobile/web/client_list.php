<?php include '../config/config.php';

$name=$_GET['name'];
$tel=$_GET['tel'];
$projectId=$_GET['projectId'];


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
if($projectId!=""){
    $sqlKey .= " and t.`project_id` = '$projectId'";
}
if($tel!=""){
    $sqlKey .= " and t.`tel` like '%$tel%'";
}


$Query = "Select count(*) as c from t_client where t.employee_id='".$_COOKIE['userId']."' and is_del=0 $sqlKey";
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
FROM t_client as t 
left join t_project as p on t.project_id=p.id
left join t_employee as e on t.employee_id=e.id 
left join t_company as c on e.company_id=c.id
left join t_dictionary as d_ps on t.price_status=d_ps.value and d_ps.type='price_status' 
            where t.employee_id='".$_COOKIE['userId']."' and t.is_del=0 $sqlKey order by t.id desc limit $offset,$Page_size";
//echo $sql;
$result = mysql_query($sql);
$content="";
while ($row = mysql_fetch_array($result)) {
$content.="<tr>\n";
$content.="<th>".$row['project_name']."</th>\n";

$content.="<td>".$row['price']."(".$row['price_status_name'].")</td>\n";
if(!empty($row['end_price_time'])){
    $end_price_time=date("Y-m-d",strtotime($row['end_price_time']));
}else{
    $end_price_time="";
}
$content.="<td>".$end_price_time."</td>\n";
if(empty($row['visit_date'])){
    $visit_date="<a href='#' onclick='popOpen(\"".$row['id']."\");'>填加日期</a>";
}else{
    $visit_date=date("Y-m-d",strtotime($row['visit_date']));
}

$content.="<td>".$visit_date."</td>\n";
$content.="<td>".$row['name']."(".$row['id'].")</td>\n";
$content.="<td>".$row['tel']."</td>\n";
$editBtnStr="";
if($row["check_status"]==1){
    $editBtnStr="已签约";
}else{
    $editBtnStr="<a data-role=\"button\"  href=\"#\" onclick=\"window.location.href='client_edit.php?id=".$row['id']."&action=edit'\">编辑</a>";
}


$content.="    <td >$editBtnStr</td>";
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
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width" /> 
<link rel="stylesheet" href="../jquery/jquery.mobile-1.3.2.min.css">
<script src="../jquery/jquery-1.8.3.min.js"></script>
<script src="../jquery/jquery.mobile-1.3.2.min.js"></script>
</head>
<script language="javascript">
$(document).ready(function(){

})

	function searchPost(){
		window.location.href="?1=1&"+$("#searchForm").serialize();	
	}

function submitForm(){
	//alert("ddd");
	
	
	if($("#visitDate").val().length==0){
		$("#errMsg").html('日期不能为空！');
		return false;
	}

    $("#errMsg").html('正在提交请稍后....！');

	$.post(	"../lib/client_edit.php", 
		$("#editForm").serialize(), 
		function(data,st){
			var resultArr=data.split("|");
			$("#errMsg").html(resultArr[1]);
			$("#myPopup").popup('close');
			window.location.reload();
		});
}
function popOpen(id){
	$("#errMsg").html('');
	$("#id").val(id);
	$("#myPopup").popup('open');
}
</script>
<body>
<script>


</script>
<div data-role="page" id="page1">
<?php include 'header.php';?>

  <div data-role="content">
  
  <form id="searchForm" name="searchForm"  method="post" >
  	项目: <select name="projectId" id="projectId">
  	<option value="">请选择</option>
  	      <?php 
        	$q = "select * from t_project order by id desc";                   //SQL查询语句
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
	姓名: <input type="text" name="name" id="name" value="<?php echo $name;?>" />
	电话: <input type="text" name="tel" id="tel" value="<?php echo $tel;?>"/>
    <a href="#" data-role="button" onClick="searchPost();"><img src="../images/seek.gif">查询</a>
	</form>
 <table data-role="table" id="table-column-toggle" data-mode="reflow"  class="ui-responsive table-stroke">
     <thead>
       <tr>
         <th data-priority="2">项目名称</th>
         <th data-priority="2">佣金(状态)</th>
         <th data-priority="3">结佣日期</th>
         <th data-priority="3">来访日期</th>
         <th data-priority="3"><abbr title="Rotten Tomato Rating">客户姓名(编号)</abbr></th>
         <th data-priority="5">客户电话</th>
         <th data-priority="2">操作</th>
       </tr>
     </thead>
     <tbody>
        <?php  echo $content;?>
     </tbody>
   </table>
    <?php echo $key;?>
  </div>
 <div data-role="popup" id="myPopup" class="ui-content">
      <a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn ui-icon-delete ui-btn-icon-notext ui-btn-right">X</a>
       <form id="editForm" name="editForm"  method="post" >
       <p id="errMsg" style="color:#F00"></p>    
       <p> <label for="bday">来访日期：</label>
       <input type="hidden" value="visit" name="action" id="action">
       <input type="hidden"  name="id" id="id">
        <input type="date" name="visitDate" id="visitDate"></p>
        <a href="#" data-role="button" onClick="submitForm();"><img src="../images/add.gif">保存</a>
        <a href="#" data-rel="back" data-role="button" ><img src="../images/delete.gif">关闭</a>
    </form>
    </div>
<?php include 'footer.php';?>
</div> 


</body>
</html>
<?php mysql_close($con);?>