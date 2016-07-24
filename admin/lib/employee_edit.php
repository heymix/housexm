<?php include '../config/config.php';

$userName=$_POST["userName"];
$trueName=$_POST["trueName"];
$companyId=$_POST["companyId"];
$userId=$_POST["userId"];
$password=$_POST["password"];
$sex=$_POST["sex"];
$tel=$_POST["tel"];
$remark=$_POST["remark"];
$action=$_POST["action"];
$id=$_POST["id"];
$subBox=$_POST["subBox"];

$operateUser=$_SESSION["userId"];

//echo $action;
//echo $db_name;
/* echo $type.$name.$value.$orderId; */
//var_dump($name);

mysql_select_db($db_name, $con);          //选择数据库
mysql_query($char_set);
if ($action==="save"){
    $query = "select id from t_employee where user_name='$userName' and is_del=0";                   //SQL查询语句
    mysql_query($char_set);
    $rs = mysql_query($query, $con);                     //获取数据集
    if(!$rs){die("0|Valid result!");}
    if(mysql_num_rows($rs)>=1){
        echo "0|操作失败，数据重复！";
    }else{
        $password=md5($password);
        $query="insert into t_employee (`user_name`,`true_name`,`company_id`,`tel`,`remark`,`password`,`sex`,user_id,`create_user`,`create_time`)values ('$userName','$trueName','$companyId','$tel','$remark','$password','$sex','$userId','$operateUser',now())";
        mysql_query($query,$con);
        echo "1|添加成功！";
    }
}
if($action==="edit"){
    if($password!=""){
        $password=md5($password);
        $updateSql=",password='$password'";
    }
    $query = "update t_employee set `true_name`='$trueName',`company_id`='$companyId',`tel`='$tel',`remark`='$remark',`sex`='$sex',`user_id`='$userId',update_time=now(),update_user='$operateUser' $updateSql where id=$id";
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
