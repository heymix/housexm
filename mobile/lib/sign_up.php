<?php include '../config/conn.php';

$parentId=$_POST["parentId"];
$promotionId=$_POST["promotionId"];
$name=$_POST["name"];
$tel=$_POST["tel"];

$action=$_POST["action"];
$id=$_POST["id"];




$power=postArr($_POST["power"]);


$subBox=$_POST["subBox"];

$operateUser=$_COOKIE["userId"];


//echo $db_name;
/* echo $type.$name.$value.$orderId; */
//var_dump($power);
mysql_select_db($db_name, $con);          //选择数据库
mysql_query($char_set);
if ($action==="save"){
    $query = "select id from t_promotion_client where `tel`='$tel' and `promotion_id`='$promotionId' and
                                       `parent_id`='$parentId' and is_del=0";                   //SQL查询语句
    mysql_query($char_set);
    $rs = mysql_query($query, $con);                     //获取数据集
    if(!$rs){die("0|Valid result!");}
    if(mysql_num_rows($rs)>=1){
        echo "0|操作失败，已经注册过！";
    }else{
        $query="insert into t_promotion_client (`name`,`tel`,`promotion_id`,`parent_id`,`create_user`,`create_time`)values 
                                        ('$name','$tel','$promotionId','$parentId','$operateUser',now())";
        $isSuccess=mysql_query($query,$con);
        if($isSuccess===false){
            echo "0|添加失败： 数据错误！错误代码：db001";
        }else{
            echo "1|添加成功！";
        }
       
    }   
}
if($action==="edit"){

    $query = "update t_promotion_client set `name`='$name',`tel`='$tel',`promotion_id`='$promotionId',
                                       `parent_id`='$parentId',
    update_time=now(),update_user='$operateUser' where id=$id";
    mysql_query($query,$con);
    $isSuccess=mysql_query($query,$con);
    if($isSuccess===false){
        echo "0|修改失败： 数据错误！错误代码：db001";
    }else{
        echo "1|修改成功！category";
    }
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
    $query="update t_promotion_client set is_del='1',update_time=now(),update_user='$operateUser' where id in($idArr)";
    $isSuccess=mysql_query($query,$con);
    if($isSuccess===false){
        echo "0|删除失败： 数据错误！错误代码：$query";
    }else{
        echo "1|删除成功！";
    }
}

 mysql_close($con);

?>
