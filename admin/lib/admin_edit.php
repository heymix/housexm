<?php include '../config/config.php';

$userName=$_POST["userName"];
$companyId=$_POST["companyId"];
$password=$_POST["password"];
$remark=$_POST["remark"];
$action=$_POST["action"];
$id=$_POST["id"];

$roleId=$_POST["roleId"];


$subBox=$_POST["subBox"];

$operateUser=$_SESSION["userId"];


//echo $db_name;
/* echo $type.$name.$value.$orderId; */
//var_dump($power);
mysql_select_db($db_name, $con);          //选择数据库
mysql_query($char_set);
if ($action==="save"){
    $query = "select id from t_admin where user_name='$userName' and is_del=0";                   //SQL查询语句
    mysql_query($char_set);
    $rs = mysql_query($query, $con);                     //获取数据集
    if(!$rs){die("0|Valid result!");}
    if(mysql_num_rows($rs)>=1){
        echo "0|操作失败，数据重复！";
    }else{
        $password=md5($password);
        $query="insert into t_admin (`user_name`,`company_id`,`remark`,`password`,`role_id`,`create_user`,`create_time`)values ('$userName','$companyId','$remark','$password','$roleId','$operateUser',now())";
        mysql_query($query,$con);
        echo "1|添加成功！";
    }
}
if($action==="edit"){
    if($password!=""){
        $password=md5($password);
        $updateSql=",password='$password'";
    }
    $query = "update t_admin set `remark`='$remark',update_time=now(),update_user='$operateUser',role_id='$roleId' $updateSql where id=$id";
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
    $query="update t_admin set is_del='1',update_time=now(),update_user='$operateUser' where id in($idArr)";
    mysql_query($query,$con);
    echo "1|删除成功！";
}

 mysql_close($con);

?>
