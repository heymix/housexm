<?php include '../config/conn.php';

$trueName=$_POST["trueName"];
$userName=$_POST["userName"];
$tel=$_POST["tel"];
$wechat=$_POST["wechat"];
$parentId=$_POST["parentId"];
$companyId=$_POST["companyId"];
$password=$_POST["password"];

//echo $operateUser;
//echo $action;
//echo $db_name;
/* echo $type.$name.$value.$orderId; */
//var_dump($name);

mysql_select_db($db_name, $con);          //选择数据库
mysql_query($char_set);
if($parentId!=""){
    $query = "select id from t_employee where id='$parentId' and is_del=0";                   //SQL查询语句
    mysql_query($char_set);
    $rs = mysql_query($query, $con);
    if(!$rs){die("0|Valid result!");}
    if(mysql_num_rows($rs)>=1){
        die("0|操作失败，推荐人不存在！");
    }
}else{
    $parentId=0;
}
if($companyId==""){
    die("0|操作失败，公司不能为空！");
}
    

    $query = "select id from t_employee where  tel='$tel' and is_del=0";                   //SQL查询语句
    mysql_query($char_set);
    $rs = mysql_query($query, $con);                     //获取数据集
    if(!$rs){die("0|Valid result!");}
    if(mysql_num_rows($rs)>=1){
        echo "0|操作失败，电话号重复！";
    }else{
        $query = "select id from t_employee where user_name='$userName' and is_del=0";                   //SQL查询语句
        mysql_query($char_set);
        $rs = mysql_query($query, $con);                     //获取数据集
        if(!$rs){die("0|Valid result!");}
        if(mysql_num_rows($rs)>=1){
            echo "0|操作失败，用户名重复！";
        }else{
            $password=md5($password);
            $query="insert into t_employee (`true_name`,`user_name`,`tel`,`wechat`,`parent_id`,`company_id`,`password`,`create_time`)values 
                                        ('$trueName','$userName','$tel','$wechat','$parentId','$companyId','$password',now())";
            mysql_query($query,$con);
            echo "1|添加成功！";
        }
    }

 mysql_close($con);

?>
