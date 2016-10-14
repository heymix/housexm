<?php include '../config/config.php';

$name=$_POST["name"];
$simpleName=$_POST["simpleName"];
$contact=$_POST["contact"];
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
    $query = "select id from t_company where name='$name' and is_del=0";                   //SQL查询语句
    mysql_query($char_set);
    $rs = mysql_query($query, $con);                     //获取数据集
    if(!$rs){die("0|Valid result!");}
    if(mysql_num_rows($rs)>=1){
        echo "0|操作失败，数据重复！";
    }else{
        $query="insert into t_company (`simple_name`,`name`,`pinyin_name`,`contact`,`tel`,`remark`,`create_user`,`create_time`)values ('$simpleName','$name',to_pinyin('$name'),'$contact','$tel','$remark','$operateUser',now())";
        mysql_query($query,$con);
        echo "1|添加成功！";
    }
}
if($action==="edit"){
    $query = "update t_company set `name`='$name',`simple_name`='$simpleName',`contact`='$contact',`tel`='$tel',`remark`='$remark',pinyin_name=to_pinyin('$name'),update_time=now(),update_user='$operateUser' where id=$id";
    mysql_query($query,$con);
    echo "1|修改成功！$query";
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
    $query="update t_company set is_del='1',update_time=now(),update_user='$operateUser' where id in($idArr)";
    mysql_query($query,$con);
    echo "1|删除成功！";
}

 mysql_close($con);

?>
