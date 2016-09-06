<?php include '../config/config.php';

$name=$_POST["name"];
$tel=$_POST["tel"];
$projectId=$_POST["project"];
$visitDate=$_POST["visitDate"];

$sex=$_POST["sex"];
$age=$_POST["age"];
$family=$_POST["family"];


$district=$_POST["district"];
$metro=$_POST["metro"];
$school=$_POST["school"];
$school_ext=$_POST["school_ext"];
$category=$_POST["category"];
$hope_area=$_POST["hope_area"];
$hot_type=$_POST["hot_type"];
$hope_price=$_POST["hope_price"];
$hope_total_price=$_POST["hope_total_price"];
$house_type=$_POST["house_type"];
$hot_business=$_POST["hot_business"];
$intention=$_POST["intention"];
$intention_ext=$_POST["intention_ext"];

$filedStr="";
$valueStr="";
$updateSql="";
if(!empty($sex)){
    $filedStr.=" ,`sex`";
    $valueStr.=" ,'$sex'";
    $updateSql.=" ,`sex`='$sex'";
}
if(!empty($age)){
    $filedStr.=" ,`age`";
    $valueStr.=" ,'$age'";
    $updateSql.=" ,`age`='$age'";
}
if(!empty($family)){
    $filedStr.=" ,`family`";
    $valueStr.=" ,'$family'";
    $updateSql.=" ,`family`='$family'";
}
if(!empty($district)){
    $filedStr.=" ,`district`";
    $valueStr.=" ,'".postArr($district)."'";
    $updateSql.=" ,`district`='".postArr($district)."'";
}
if(!empty($metro)){
    $filedStr.=" ,`metro`";
    $valueStr.=" ,'".postArr($metro)."'";
    $updateSql.=" ,`metro`='".postArr($metro)."'";
}
if(!empty($school)){
    $filedStr.=" ,`school`";
    $valueStr.=" ,'".postArr($school)."'";
    $updateSql.=" ,`school`='".postArr($school)."'";
}

if(!empty($school_ext)){
    $filedStr.=" ,`school_ext`";
    $valueStr.=" ,'".$school_ext."'";
    $updateSql.=" ,`school_ext`='".$school_ext."'";
}
if(!empty($category)){
    $filedStr.=" ,`category`";
    $valueStr.=" ,'".postArr($category)."'";
    $updateSql.=" ,`category`='".postArr($category)."'";
}
if(!empty($hope_area)){
    $filedStr.=" ,`hope_area`";
    $valueStr.=" ,'".postArr($hope_area)."'";
    $updateSql.=" ,`hope_area`='".postArr($hope_area)."'";
}
if(!empty($hot_type)){
    $filedStr.=" ,`hot_type`";
    $valueStr.=" ,'".postArr($hot_type)."'";
    $updateSql.=" ,`hot_type`='".postArr($hot_type)."'";
}
if(!empty($hope_price)){
    $filedStr.=" ,`hope_price`";
    $valueStr.=" ,'".postArr($hope_price)."'";
    $updateSql.=" ,`hope_price`='".postArr($hope_price)."'";
}
if(!empty($hope_total_price)){
    $filedStr.=" ,`hope_total_price`";
    $valueStr.=" ,'".postArr($hope_total_price)."'";
    $updateSql.=" ,`hope_total_price`='".postArr($hope_total_price)."'";
}

if(!empty($house_type)){
    $filedStr.=" ,`house_type`";
    $valueStr.=" ,'".postArr($house_type)."'";
    $updateSql.=" ,`house_type`='".postArr($house_type)."'";
}

if(!empty($hot_business)){
    $filedStr.=" ,`hot_business`";
    $valueStr.=" ,'".postArr($hot_business)."'";
    $updateSql.=" ,`hot_business`='".postArr($hot_business)."'";
}

if(!empty($intention)){
    $filedStr.=" ,`intention`";
    $valueStr.=" ,'".postArr($intention)."'";
    $updateSql.=" ,`intention`='".postArr($intention)."'";
}

if(!empty($intention_ext)){
    $filedStr.=" ,`intention_ext`";
    $valueStr.=" ,'".$intention_ext."'";
    $updateSql.=" ,`intention_ext`='".$intention_ext."'";
}




$operateUser=$_COOKIE["userId"];
$companyId=$_COOKIE["companyId"];



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
    
    $query = "select c.id from t_client as c left join t_employee as e
    on c.employee_id=e.id
    where e.company_id='$companyId' and c.project_id='$projectId' and c.tel='$tel' and c.is_del=0";                   //SQL查询语句
    mysql_query($char_set);
    $rs = mysql_query($query, $con);                     //获取数据集
    if(!$rs){die("0|Valid result!");}
    if(mysql_num_rows($rs)>=1){
        echo "0|操作失败，数据重复！";
    }else{
        $password=md5($password);
        $query="insert into t_client (`name`,`tel`,`project_id`,`employee_id`,`create_user`,`create_time` $filedStr)values 
                                    ('$name','$tel','$projectId','$operateUser','$operateUser',now() $valueStr)";
        mysql_query($query,$con);
        echo "1|添加成功！$query";
    }
}
if($action==="edit"){
    $query = "select id from t_client 
    where  check_status=1  and id=$id and is_del=0";                   //SQL查询语句
    mysql_query($char_set);
    $rs = mysql_query($query, $con);                     //获取数据集
    if(!$rs){die("0|Valid result!");}
    if(mysql_num_rows($rs)>=1){
        echo "0|操作失败，已经签约不可修改！";
    }else{
        $query = "select c.id from t_client as c left join t_employee as e
        on c.employee_id=e.id
         where e.company_Id='$companyId' and c.project_id='$projectId' and c.tel='$tel' and c.id<>$id and c.is_del=0";                   //SQL查询语句
        mysql_query($char_set);
        $rs = mysql_query($query, $con);                     //获取数据集
        if(!$rs){die("0|Valid result!");}
        if(mysql_num_rows($rs)>=1){
            echo "0|操作失败，数据重复！";
        }else{
            $query = "update t_client set `name`='$name',`tel`='$tel',update_time=now(),update_user='$operateUser' $updateSql where id=$id";
            mysql_query($query,$con);
            echo "1|修改成功！";
        }
    }
}
if ($action==="visit"){
    mysql_query($char_set);
    $rs = mysql_query($query, $con);
    $query = "update t_client set `visit_date`='$visitDate',update_time=now(),update_user='$operateUser' where id=$id";
    mysql_query($query,$con);
    echo "1|来访日期修改成功！";
}



 mysql_close($con);

?>
