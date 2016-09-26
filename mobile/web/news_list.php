<?php include '../config/config.php';

$title=$_GET['title'];
$desc=$_GET['desc'];
$category=$_GET['category'];

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
if ($title!=""){
    $sqlKey .= " and p.title like '%$title%'";
}

if ($desc!=""){
    $sqlKey .= " and p.desc like '%$desc%'";
}

if ($category!=""){
    $sqlKey .= " and p.category = '$category'";
}





$Query = "Select count(*) as c from t_promotion as p where 1=1 and p.is_del=0 $sqlKey";
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
$sql = "select p.*,d.name as category_name from t_promotion as p left join t_dictionary as d on p.category=d.value and d.type='news_category' 
            where 1=1 and p.is_del=0 $sqlKey order by p.id desc limit $offset,$Page_size";
$result = mysql_query($sql);
$content="";
while ($row = mysql_fetch_array($result)) {

$content.="<li onclick='window.location.href=\"news_detail.php?id=".$row["id"]."\"'>\n";
$content.="<img src='../../upload/images/".$row["image"]."' />\n";
$content.="<h3>".$row["title"]."</h3>\n";
$content.="<p>".$row["desc"]."</p>\n";
if(!empty($row['update_time'])){
    $update_time=date("Y-m-d",strtotime($row['update_time']));
}else{
    $update_time="";
}
$content.="<p class='ui-li-aside'>$update_time</p>\n";
$content.="</li>\n";
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
  
  <form id="searchForm" name="searchForm"  method="post" style="display: none" >
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
	</form><br>
        <ul data-role="listview" data-split-icon="delete">
            <li data-role="list-divider">活动列表</li>
            <?php echo $content;?>
        </ul>
        <br>
    <?php echo $key;?>
  </div>

<?php include 'footer.php';?>
</div> 


</body>
</html>
<?php mysql_close($con);?>