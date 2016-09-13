<?php include '../config/conn.php';

$parentId=$_POST["parentId"];
$promotionId=$_POST["promotionId"];
$name=$_POST["name"];
$tel=$_POST["tel"];

$action=$_POST["action"];


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
        $query="insert into t_promotion_client (`name`,`tel`,`promotion_id`,`parent_id`,`create_time`)values 
                                        ('$name','$tel','$promotionId','$parentId',now())";
        $isSuccess=mysql_query($query,$con);
        if($isSuccess===false){
            echo "0|添加失败： 数据错误！错误代码：db001";
        }else{
            echo "1|添加成功！";
        }
       
    }   
}



 mysql_close($con);

?>
