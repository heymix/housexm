<?php 
session_start();
include '../config/conn.php';

$userName=$_POST["UserName"];
$password=$_POST["PassWord"];


if ($userName==""){
    die ("0|用户名不能为空!");
}
if ($password==""){
    die ("0|密码不能为空!");
}
mysql_select_db($db_name, $con);          //选择数据库
mysql_query($char_set);
$query="delete from t_login_check where info_time<".(time()-300);
mysql_query($query,$con); 
$query="insert into t_login_check (user_name,info_time) values ('$userName',".time().")";
mysql_query($query,$con);
 $query = "select id from t_login_check where user_name='$userName'";                   //SQL查询语句
mysql_query($char_set);
$rs = mysql_query($query, $con);                     //获取数据集
if(!$rs){die("0|Valid result!");} 
if (mysql_num_rows($rs)>5){
    die ("0|连续失败5次,锁定用户登录10分钟。");
} 
$query = "select a.id,a.company_id,c.name as company_name from t_admin as a left join t_company as c on a.company_id=c.id where a.user_name='$userName' and a.password='". md5($password) ."' and a.is_del=0";  
//echo $query;//SQL查询语句
mysql_query($char_set);
$rs = mysql_query($query, $con);                     //获取数据集
if(!$rs){die("0|Valid result!");}
if(mysql_num_rows($rs)>=1){
    echo ("1|登录成功!");
    $row  = mysql_fetch_array($rs);
    $_SESSION['userName'] = "$userName";
    $_SESSION['userId'] = $row['id'];
    $_SESSION['companyId'] = $row['company_id'];
    $_SESSION['companyName'] = $row['company_name'];
    
    $query="delete from t_login_check where user_name='$userName'";
    mysql_query($query,$con);
}else{
    
    echo ("0|用户名或密码错误!");
} 


 mysql_close($con);

?>
