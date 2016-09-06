<?php include '../config/config.php';

$oldPassword=$_POST["oldPassword"];
$password=$_POST["password"];
$id=$_POST["id"];
//echo $operateUser;
//echo $action;
//echo $db_name;
/* echo $type.$name.$value.$orderId; */
//var_dump($name);
$operateUser=$_COOKIE["userId"];
mysql_select_db($db_name, $con);          //选择数据库
mysql_query($char_set);

    $oldPassword=md5($oldPassword);
    $password=md5($password);
    $query = "select id from t_employee where password='$oldPassword' and id='$operateUser' and is_del=0";                   //SQL查询语句
    mysql_query($char_set);
    $rs = mysql_query($query, $con);                     //获取数据集
    if(!$rs){die("0|Valid result!");}
    if(mysql_num_rows($rs)!=1){
        echo "0|操作失败，原密码不正确！";
    }else{
        $query = "update t_employee set `password`='$password',update_time=now(),update_user='$operateUser' where id=$operateUser";
        mysql_query($query,$con);
        echo "1|修改成功！";
    }
 mysql_close($con);

?>
