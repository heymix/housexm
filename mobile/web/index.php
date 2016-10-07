<?php include '../config/config.php';

$title=$_GET['title'];
$desc=$_GET['desc'];
$category=$_GET['category'];
$parentId=$_COOKIE["userId"];

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

$content.="<li onclick='window.location.href=\"news_detail.php?id=".$row["id"]."&parentId=$parentId\"'>\n";
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




/**
 *
 * @param unknown $title 标题
 * @param unknown $type 字典类型
 * @param unknown $cate input 类别
 * @param unknown $db_name 数据库名
 * @param unknown $con 连接数据库
 * @param unknown $char_set
 * @param unknown $dateStr 修改数据
 * @return string
 */
function checkbox($title,$type,$cate,$db_name,$con,$char_set,$dateStr){

    $nameArr="";
    if ($cate==""||$cate=="checkbox"){
        $cate="checkbox";
        $nameArr="[]";
    }else{
        $nameArr="";
    }
    mysql_select_db($db_name, $con);          //选择数据库
    $returnStr="";
    $q = "select * from t_dictionary where `type`='$type' order by order_id asc";                   //SQL查询语句
    mysql_query($char_set);
    $rs = mysql_query($q, $con);                     //获取数据集
    //echo $q;
    if(!$rs){die("Valid result!");}

    $returnStr.="<fieldset data-role='controlgroup'>\n";
    $returnStr.="<legend>".$title."：</legend>\n";
    $i=0;
    while($row = mysql_fetch_array($rs)) {
        $i=$i+1;
        $checked="";
        if($cate=="checkbox"){
            if(strpos($dateStr, ",".$row["value"].",") !== false){
                $checked="checked";
            }
        }
        if($cate=="radio"){
            if($row["value"]==$dateStr){
                $checked="checked";
            }
        }


        $returnStr.="<label for='$type$i'>".$row["name"]."</label>\n";
        $returnStr.="<input type='$cate' name='$type$nameArr' id='$type$i' value='".$row["value"]."' $checked>\n";
    }
    $returnStr.=" </fieldset>";
    return $returnStr;
}
?>
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
	

	if($("#name").val().length==0){
		$("#errMsg").html('姓名不能为空！');
		return false;
	}
	if($("#tel").val().length==0){
		$("#errMsg").html('手号码不能为空！');
		return false;
	}

$("#errMsg").html('正在提交请稍后....！');

	$.post(	"../lib/client_edit.php", 
		$("#editForm").serialize(), 
		function(data,st){
			var resultArr=data.split("|");
			$("#errMsg").html(resultArr[1]);
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
  
  
        <ul data-role="listview" data-split-icon="delete">
            <li data-role="list-divider">活动列表</li>
            <?php echo $content;?>
        </ul>
        <br>
    <?php echo $key;?>
  </div>
<p id="errMsg" style="color:#F00"></p>
  	<form id="editForm" name="editForm"  method="post" >
  	<?php if($action=='edit'){
  	echo "<input id='project' name='project' type='hidden' value='$projectId'>";
  	}
  	    ?>
  	项目: <select <?php if($action=='edit') echo "disabled";?>  name="project" id="project">
  	      <?php 
        	$q = "select * from t_project where is_del=0 order by id desc";                   //SQL查询语句
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
  <input id="id" name="id" value="<?php echo $id?>" type=hidden>
  <input id="action" name="action" value="<?php echo $action?>" type=hidden>
	姓名: <input type="text" name="name" id="name" value="<?php echo $name;?>"/>
	电话: <input type="text" name="tel" id="tel" value="<?php echo $tel;?>" />
     <fieldset data-role="controlgroup">
      <legend>请选择您的性别：</legend>
        <label for="male">先生</label>
        <input type="radio" name="sex" id="male" value="男" <?php if($sex=="男") echo "checked"?>>
        <label for="female">女士</label>
        <input type="radio" name="sex" id="female" value="女" <?php if($sex=="女") echo "checked"?>>	
      </fieldset>
      <?php 
            echo checkbox("年龄","age","radio",$db_name,$con,$char_set,$age);
            echo checkbox("家庭人口结构","family","radio",$db_name,$con,$char_set,$family);
        	echo checkbox("区域","district","checkbox",$db_name,$con,$char_set,$district);
        	echo checkbox("地铁","metro","checkbox",$db_name,$con,$char_set,$metro);
        	echo "学校: <input type='text'' name='school_ext' id='school_ext' value='$school_ext'/>";
        	echo checkbox("学校","school","checkbox",$db_name,$con,$char_set,$school);
        	echo checkbox("类型","category","checkbox",$db_name,$con,$char_set,$category);
        	echo checkbox("面积","hope_area","checkbox",$db_name,$con,$char_set,$hope_area);
        	echo checkbox("热门","hot_type","checkbox",$db_name,$con,$char_set,$hot_type);
        	echo checkbox("单价","hope_price","checkbox",$db_name,$con,$char_set,$hope_price);
        	echo checkbox("总价","hope_total_price","checkbox",$db_name,$con,$char_set,$hope_total_price);
        	echo checkbox("户型","house_type","checkbox",$db_name,$con,$char_set,$house_type);
        	echo checkbox("热门商圈","hot_business","checkbox",$db_name,$con,$char_set,$hot_business);
        	echo "近期购买意向楼盘: <input type='text'' name='intention_ext' id='intention_ext' value='$intention_ext'/>";
        	echo checkbox("近期购买意向","intention","checkbox",$db_name,$con,$char_set,$intention);
        	?>
    <a href="#" data-role="button" onClick="submitForm();"><img src="../images/add.gif">保存</a>
	</form>
<?php include 'footer.php';?>
</div> 


</body>
</html>
<?php mysql_close($con);?>