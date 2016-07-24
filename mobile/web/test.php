<?php include '../config/config.php';

$name=$_GET['name'];
$simpleName=$_GET['simpleName'];
$houseType=$_GET['houseType'];
$contact=$_GET['contact'];
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
if ($name!=""){
    $sqlKey .= " and p.`name` like '%$name%'";
}
if($simpleName!=""){
    $sqlKey .= " and p.`simple_name` like '%$simpleName%'";
}
if($contact!=""){
    $sqlKey .= " and p.`contact` like '%$contact%'";
}
if($houseType!=""){
    $sqlKey .= " and (d.`value` = '$houseType' and d.type='house_type') ";
}
if($remark!=""){
    $sqlKey .= " and p.`remark` like '%$remark%'";
}

if($tel!=""){
    $sqlKey .= " and p.`tel` like '%$tel%'";
}


$Query = "Select count(*) as c from t_client where is_del=0 $sqlKey";
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
$content.="    <td height='18' >".$row['true_name']."(".$row['user_name'].")</td>\n";
$content.="    <td height='18' >".$row['employee_tel']."</td>\n";
$content.="    <td height='18' >".$row['hosue_type_name']."</td>\n";
$content.="    <td height='18' >".$row['contact']."</td>\n";
$content.="    <td height='18' >".$row['tel']."</td>\n";
$content.="    <td height='18' >".$row['tel']."</td>\n";
$content.="    <td height='18' >".$row['tel']."</td>\n";
$content.="    <td height='18' >".$row['tel']."</td>\n";
$content.="    <td height='18' >".$row['tel']."</td>\n";
$content.="    <td height='18' >".$row['tel']."</td>\n";
$content.="    <td height='18' >".$row['remark']."</td>\n";
$content.="    <td height='18'><img src='../images/edit.gif'>[<a href=\"project_edit.php?id=".$row['id']."&action=edit\">编辑</a>]</td>";
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
<title>jquery mobile Table Column Toggle使用 </title>
<link rel="stylesheet" href="../jquery/jquery.mobile-1.3.2.min.css">
<script src="../jquery/jquery-1.8.3.min.js"></script>
<script src="../jquery/jquery.mobile-1.3.2.min.js"></script>
<style>
</style>
</head>
<body>
<div data-role="page" id="pageone">
  <div data-role="header">
  
     <a href="#" onClick="window.history.go(-1);" data-role="button">返回</a><h1>中奖用户列表</h1>
     
     <a href="#menu" data-rel="popup" data-role="button">...</a>
  <div data-role="popup" id="menu" data-theme="a">
    <ul data-role="listview" data-theme="c" data-inset="true">
        <li data-role="divider" data-theme="a">菜单</li>
        <li><a href="#" onclick='window.location.href="../index.php"'>首页</a></li>
        <li><a href="#" onclick='window.location.href="client_edit.php"'>新增</a></li>
        <li><a href="#" onclick='window.location.href="client_list.php"'>查询</a></li>
        <li><a href="#" onclick='window.location.href="../index.php?action=logout"'>退出</a></li>
    </ul>
  </div>
  </div>
 <table data-role="table" id="table-column-toggle" data-mode="reflow"  class="ui-responsive table-stroke">
     <thead>
       <tr>
         <th data-priority="2">Rank</th>
         <th>Movie Title</th>
         <th data-priority="3">Year</th>
         <th data-priority="1"><abbr title="Rotten Tomato Rating">Rating</abbr></th>
         <th data-priority="5">Reviews</th>
       </tr>
     </thead>
     <tbody>
       <tr>
         <th>1</th>
         <td><a href="#" data-rel="external">Citizen Kane</a></td>
         <td>1941</td>
         <td>100%</td>
         <td>74</td>
       </tr>
       <tr>
         <th>2</th>
         <td><a href="#" data-rel="external">Casablanca</a></td>
         <td>1942</td>
         <td>97%</td>
         <td>64</td>
       </tr>
       <tr>
         <th>3</th>
         <td><a href="#" data-rel="external">The Godfather</a></td>
         <td>1972</td>
         <td>97%</td>
         <td>87</td>
       </tr>
       <tr>
         <th>4</th>
         <td><a href="#" data-rel="external">Gone with the Wind</a></td>
         <td>1939</td>
         <td>96%</td>
         <td>87</td>
       </tr>
       <tr>
         <th>5</th>
         <td><a href="#" data-rel="external">Lawrence of Arabia</a></td>
         <td>1962</td>
         <td>94%</td>
         <td>87</td>
       </tr>
       <tr>
         <th>6</th>
         <td><a href="#" data-rel="external">Dr. Strangelove Or How I Learned to Stop Worrying and Love the Bomb</a></td>
         <td>1964</td>
         <td>92%</td>
         <td>74</td>
       </tr>
       <tr>
         <th>7</th>
         <td><a href="#" data-rel="external">The Graduate</a></td>
         <td>1967</td>
         <td>91%</td>
         <td>122</td>
       </tr>
       <tr>
         <th>8</th>
         <td><a href="#" data-rel="external">The Wizard of Oz</a></td>
         <td>1939</td>
         <td>90%</td>
         <td>72</td>
       </tr>
       <tr>
         <th>9</th>
         <td><a href="#" data-rel="external">Singin' in the Rain</a></td>
         <td>1952</td>
         <td>89%</td>
         <td>85</td>
       </tr>
       <tr>
         <th>10</th>
         <td class="title"><a href="#" data-rel="external">Inception</a></td>
         <td>2010</td>
         <td>84%</td>
         <td>78</td>
       </tr>
     </tbody>
   </table>
     <div data-role="footer">
  <h1>北 车 地 产</h1>
  </div>
</div>
</body>
</html>
<?php mysql_close($con);?>