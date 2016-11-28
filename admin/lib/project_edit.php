<?php include '../config/config.php';

$name=$_POST["name"];
$simpleName=$_POST["simpleName"];
$address=$_POST["address"];
$houseType=$_POST["houseType"];
$contact=$_POST["contact"];
$tel=$_POST["tel"];
$remark=$_POST["remark"];


$seller =$_POST["seller"];
$areaMin =$_POST["areaMin"];
$areaMax =$_POST["areaMax"];
$propertyRights =$_POST["propertyRights"];
$propertyYear =$_POST["propertyYear"];
$averagePrice =$_POST["averagePrice"];
$developers =$_POST["developers"];
$totalArea =$_POST["totalArea"];
$totalHouse =$_POST["totalHouse"];
$sellNum =$_POST["sellNum"];
$num =$_POST["num"];
$middleSchool =$_POST["middleSchool"];
$primarySchool =$_POST["primarySchool"];





$action=$_POST["action"];
$id=$_POST["id"];
$subBox=$_POST["subBox"];

$operateUser=$_SESSION["userId"];

//echo $action;
//echo $db_name;
/* echo $type.$name.$value.$orderId; */
//var_dump($name);


$filedStr="";
$valueStr="";
$updateSql="";
if(!empty($seller)){
    $filedStr.=" ,`seller`";
    $valueStr.=" ,'$seller'";
    $updateSql.=" ,`seller`='$seller'";
}
if(!empty($areaMin)){
    $filedStr.=" ,`area_min`";
    $valueStr.=" ,'$areaMin'";
    $updateSql.=" ,`area_min`='$areaMin'";
}
if(!empty($areaMax)){
    $filedStr.=" ,`area_max`";
    $valueStr.=" ,'$areaMax'";
    $updateSql.=" ,`area_max`='$areaMax'";
}
if(!empty($propertyRights)){
    $filedStr.=" ,`property_rights`";
    $valueStr.=" ,'$propertyRights'";
    $updateSql.=" ,`property_rights`='$propertyRights'";
}

if(!empty($propertyYear)){
    $filedStr.=" ,`property_year`";
    $valueStr.=" ,'$propertyYear'";
    $updateSql.=" ,`property_year`='$propertyYear'";
}
if(!empty($averagePrice)){
    $filedStr.=" ,`average_price`";
    $valueStr.=" ,'$averagePrice'";
    $updateSql.=" ,`average_price`='$averagePrice'";
}
if(!empty($developers)){
    $filedStr.=" ,`developers`";
    $valueStr.=" ,'$developers'";
    $updateSql.=" ,`developers`='$developers'";
}
if(!empty($totalArea)){
    $filedStr.=" ,`total_area`";
    $valueStr.=" ,'$totalArea'";
    $updateSql.=" ,`total_area`='$totalArea'";
}
if(!empty($totalHouse)){
    $filedStr.=" ,`total_house`";
    $valueStr.=" ,'$totalHouse'";
    $updateSql.=" ,`total_house`='$totalHouse'";
}
if(!empty($sellNum)){
    $filedStr.=" ,`sell_num`";
    $valueStr.=" ,'$sellNum'";
    $updateSql.=" ,`sell_num`='$sellNum'";
}
if(!empty($num)){
    $filedStr.=" ,`num`";
    $valueStr.=" ,'$num'";
    $updateSql.=" ,`num`='$num'";
}

if(!empty($middleSchool)){
    $filedStr.=" ,`middle_school`";
    $valueStr.=" ,'$middleSchool'";
    $updateSql.=" ,`middle_school`='$middleSchool'";
}
if(!empty($primarySchool)){
    $filedStr.=" ,`primary_school`";
    $valueStr.=" ,'$primarySchool'";
    $updateSql.=" ,`primary_school`='$primarySchool'";
}



mysql_select_db($db_name, $con);          //选择数据库
mysql_query($char_set);
if ($action==="save"){
    $query = "select id from t_project where `name`='$name' and is_del=0";                   //SQL查询语句
    mysql_query($char_set);
    $rs = mysql_query($query, $con);                     //获取数据集
    if(!$rs){die("0|Valid result!");}
    if(mysql_num_rows($rs)>=1){
        echo "0|操作失败，数据重复！";
    }else{
        $password=md5($password);
        $query="insert into t_project (`name`,`simple_name`,`address`,`house_type`,`contact`,`tel`,`remark`,`create_user`,`create_time` $filedStr)values ('$name','$simpleName','$address','$houseType','$contact','$tel','$remark','$operateUser',now() $valueStr)";
        mysql_query($query,$con);
        echo "1|添加成功！";
    }
}
if($action==="edit"){
    $query = "update t_project set `simple_name`='$simpleName',`tel`='$tel',`remark`='$remark',`contact`='$contact',`address`='$address',update_time=now(),update_user='$operateUser' $updateSql where id=$id";
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
    $query="update t_project set is_del='1',update_time=now(),update_user='$operateUser' where id in($idArr)";
    mysql_query($query,$con);
    echo "1|删除成功！";
}

 mysql_close($con);

?>
