<?php include '../config/config.php';

$type=$_POST["type"];
$name=$_POST["name"];
$value=$_POST["value"];
$orderId=$_POST["orderId"]; 
$action=$_POST["action"];
$id=$_POST["id"];

//echo $action;
//echo $db_name;
/* echo $type.$name.$value.$orderId; */

mysql_select_db($db_name, $con);          //选择数据库
mysql_query($char_set);
if ($action==="save"){
    $query = "select id from t_dictionary where type='$type' and value=$value ";                   //SQL查询语句
    mysql_query($char_set);
    $rs = mysql_query($query, $con);                     //获取数据集
    if(!$rs){die("0|Valid result!");}
    if(mysql_num_rows($rs)>=1){
        echo "0|操作失败，字典重复！";
    }else{
        mysql_query("insert into t_dictionary (`type`,`name`,`value`,`order_id`)values ('$type','$name',$value,$orderId)",$con);
        echo "1|添加成功！";
    }
}
if($action==="edit"){
    $query = "update t_dictionary set `name`='$name',`order_id`=$orderId where id=$id";
    mysql_query($query,$con);
    echo "1|修改成功！";
}
if($action==="del"){
    mysql_query("delete from t_dictionary where id=$id",$con);
    echo "1|删除成功！";
}

 mysql_close($con);

?>
