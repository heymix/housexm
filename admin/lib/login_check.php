<?php 
session_start();
include '../config/conn.php';

$userName=$_POST["UserName"];
$password=$_POST["PassWord"];
$channel=$_POST["channel"];


if ($userName==""){
    die ("0|用户名不能为空!");
}
if ($password==""){
    die ("0|密码不能为空!");
}
mysql_select_db($db_name, $con);          //选择数据库
mysql_query($char_set);
$query="delete from t_login_check where info_time<".(time()-300);
mysql_query($query,$con); 
$query="insert into t_login_check (user_name,info_time) values ('$userName',".time().")";
mysql_query($query,$con);
 $query = "select id from t_login_check where user_name='$userName'";                   //SQL查询语句
mysql_query($char_set);
$rs = mysql_query($query, $con);                     //获取数据集
if(!$rs){die("0|Valid result!");} 
if (mysql_num_rows($rs)>5){
    die ("0|连续失败5次,锁定用户登录10分钟。");
} 
if($channel==1){    
    $query = "select a.id,a.company_id,c.name as company_name,r.power from t_admin as a 
                        left join t_company as c on a.company_id=c.id 
                        left join t_role as r on a.role_id=r.id
                        where a.user_name='$userName' and a.password='". md5($password) ."' and a.is_del=0";  
    //echo $query;//SQL查询语句
    mysql_query($char_set);
    $rs = mysql_query($query, $con);                     //获取数据集
    if(!$rs){die("0|Valid result!");}
    if(mysql_num_rows($rs)>=1){
        echo ("1|登录成功!");
        $row  = mysql_fetch_array($rs);
        $_SESSION['userName'] = "$userName";
        $_SESSION['userId'] = $row['id'];
        $_SESSION['companyId'] = $row['company_id'];
        $_SESSION['companyName'] = $row['company_name'];
        $_SESSION['power'] = $row['power'];
        $_SESSION['channel'] = "1";
        
        $query="delete from t_login_check where user_name='$userName'";
        mysql_query($query,$con);
    }else{
        echo ("0|用户名或密码错误!");
    } 
}elseif($channel==2){
    
    $query = "select * from t_role where id=5";
    mysql_query($char_set);
    $rs = mysql_query($query, $con);                     //获取数据集
    if(!$rs){die("0|Valid result!");}
    if(mysql_num_rows($rs)>=1){
        $row  = mysql_fetch_array($rs);
        $power=$row["power"];
    }else{
        echo ("0|权限出问题!");
        exit;
    }
    
    $query = "select e.id,e.company_id,c.name as company_name from t_employee as e left join t_company as c on e.company_id=c.id 
    where e.user_name='$userName' and e.password='". md5($password) ."' and e.is_del=0";
    //echo $query;//SQL查询语句
    mysql_query($char_set);
    $rs = mysql_query($query, $con);                     //获取数据集
    if(!$rs){die("0|Valid result!$query");}
    if(mysql_num_rows($rs)>=1){
        echo ("1|登录成功!");
        $row  = mysql_fetch_array($rs);
        $_SESSION['userName'] = "$userName";
        $_SESSION['userId'] = $row['id'];
        $_SESSION['companyId'] = $row['company_id'];
        $_SESSION['companyName'] = $row['company_name'];
        $_SESSION['power']=$power;
        $_SESSION['channel'] = "2";
    
        $query="delete from t_login_check where user_name='$userName'";
        mysql_query($query,$con);
    }else{
        echo ("0|用户名或密码错误!");
    }
}else{
    echo ("0|错误未选择登录通道!");
}



 mysql_close($con);

?>
