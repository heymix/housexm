<?php include '../config/config.php';

$checkTime = $_POST["checkTime"];
$checkStatus = $_POST["checkStatus"];
$housePrice = $_POST["housePrice"];
$area = $_POST["area"];
$num = $_POST["num"];
$price = $_POST["price"];
$priceStatus = $_POST["priceStatus"];
$endPriceTime = $_POST["endPriceTime"];

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
/* if ($action==="save"){
    $query = "select id from t_project where `name`='$name' and is_del=0";                   //SQL查询语句
    mysql_query($char_set);
    $rs = mysql_query($query, $con);                     //获取数据集
    if(!$rs){die("0|Valid result!");}
    if(mysql_num_rows($rs)>=1){
        echo "0|操作失败，数据重复！";
    }else{
        $password=md5($password);
        $query="insert into t_project (`name`,`simple_name`,`address`,`house_type`,`contact`,`tel`,`remark`,`create_user`,`create_time`)values ('$name','$simpleName','$address','$houseType','$contact','$tel','$remark','$operateUser',now())";
        mysql_query($query,$con);
        echo "1|添加成功！";
    }
} */

$checkTime = $_POST["checkTime"];
$checkStatus = $_POST["checkStatus"];
$housePrice = $_POST["housePrice"];
$area = $_POST["area"];
$num = $_POST["num"];
$price = $_POST["price"];
$priceStatus = $_POST["priceStatus"];
$endPriceTime = $_POST["endPriceTime"];
if($action==="edit"){
    $query = "update t_client set `check_time`='$checkTime',`check_status`='$checkStatus',
                `check_time`='$checkTime',`check_status`='$checkStatus',
                `house_price`='$housePrice',`area`='$area',
                `num`='$num',`price`='$price',
                `price_status`='$priceStatus',`end_price_time`='$endPriceTime',
                `remark`='$remark',update_time=now(),update_user='$operateUser' where id=$id";
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
    $query="update t_client set is_del='1',update_time=now(),update_user='$operateUser' where id in($idArr)";
    mysql_query($query,$con);
    echo "1|删除成功！";
}

 mysql_close($con);

?>
