<?php include '../config/config.php';

$name=$_POST["name"];
$remark=$_POST["remark"];
$action=$_POST["action"];
$id=$_POST["id"];

$power=postArr($_POST["power"]);


$subBox=$_POST["subBox"];

$operateUser=$_SESSION["userId"];


//echo $db_name;
/* echo $type.$name.$value.$orderId; */
//var_dump($power);
mysql_select_db($db_name, $con);          //选择数据库
mysql_query($char_set);
if ($action==="save"){
    $query = "select id from t_role where name='$name'";                   //SQL查询语句
    mysql_query($char_set);
    $rs = mysql_query($query, $con);                     //获取数据集
    if(!$rs){die("0|Valid result!");}
    if(mysql_num_rows($rs)>=1){
        echo "0|操作失败，数据重复！";
    }else{
        $password=md5($password);
        $query="insert into t_role (`name`,`remark`,`power`,`create_user`,`create_time`)values ('$name','$remark','$power','$operateUser',now())";
        mysql_query($query,$con);
        echo "1|添加成功！";
    }
}
if($action==="edit"){

    $query = "update t_role set `remark`='$remark',update_time=now(),update_user='$operateUser',power='$power'  where id=$id";
    mysql_query($query,$con);
    echo "1|修改成功！";
}
if($action==="del"){
    $idArr="";
   foreach ($subBox as $k=>$v){
       if($idArr==""){
           $idArr=$v;
       }else{
           $idArr.=",$v";
           }
    }
    $query="delete from t_role where id in($idArr)";
    mysql_query($query,$con);
    echo "1|删除成功！";
}

 mysql_close($con);

?>
