<?php include '../config/config.php';

$name=$_POST["name"];
$tel=$_POST["tel"];
$projectId=$_POST["project"];

$operateUser=$_COOKIE["userId"];

$action=$_POST["action"];
$id=$_POST["id"];
//echo $operateUser;
//echo $action;
//echo $db_name;
/* echo $type.$name.$value.$orderId; */
//var_dump($name);

mysql_select_db($db_name, $con);          //选择数据库
mysql_query($char_set);
if ($action==="save"){
    
    $query = "select id from t_client where project_id='$projectId' and tel='$tel' and is_del=0";                   //SQL查询语句
    mysql_query($char_set);
    $rs = mysql_query($query, $con);                     //获取数据集
    if(!$rs){die("0|Valid result!");}
    if(mysql_num_rows($rs)>=1){
        echo "0|操作失败，数据重复！";
    }else{
        $password=md5($password);
        $query="insert into t_client (`name`,`tel`,`project_id`,`employee_id`,`create_user`,`create_time`)values 
                                    ('$name','$tel','$projectId','$operateUser','$operateUser',now())";
        mysql_query($query,$con);
        echo "1|添加成功！";
    }
}
if($action==="edit"){

    $query = "update t_client set `name`='$name',`tel`='$tel',update_time=now(),update_user='$operateUser' where id=$id";
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
    $query="update t_empoyee set is_del='1',update_time=now(),update_user='$operateUser' where id in($idArr)";
    mysql_query($query,$con);
    echo "1|删除成功！";
}

 mysql_close($con);

?>
