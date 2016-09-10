<?php include '../config/config.php';

$title=$_POST["title"];
$desc=$_POST["desc"];
$category =$_POST["category"];
$image =$_POST["image"];
$content =$_POST["content"];
$action=$_POST["action"];
$id=$_POST["id"];




$power=postArr($_POST["power"]);


$subBox=$_POST["subBox"];

$operateUser=$_SESSION["userId"];


//echo $db_name;
/* echo $type.$name.$value.$orderId; */
//var_dump($power);
mysql_select_db($db_name, $con);          //选择数据库
mysql_query($char_set);
if ($action==="save"){
        $password=md5($password);
        $query="insert into t_promotion (`title`,`desc`,`category`,`image`,`content`,`create_user`,`create_time`)values 
                                        ('$title','$desc','$category','$image','$content','$operateUser',now())";
        $isSuccess=mysql_query($query,$con);
        if($isSuccess===false){
            echo "0|添加失败： 数据错误！错误代码：$query";
        }else{
            echo "1|添加成功！";
        }
       
        
}
if($action==="edit"){

    $query = "update t_promotion set `title`='$title',`desc`='$desc',`category`='$category',
                                       `image`='$image',`content`='$content',
    update_time=now(),update_user='$operateUser' where id=$id";
    mysql_query($query,$con);
    $isSuccess=mysql_query($query,$con);
    if($isSuccess===false){
        echo "0|修改失败： 数据错误！错误代码：$query";
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
    $query="update t_promotion set is_del='1',update_time=now(),update_user='$operateUser' where id in($idArr)";
    $isSuccess=mysql_query($query,$con);
    if($isSuccess===false){
        echo "0|删除失败： 数据错误！错误代码：$query";
    }else{
        echo "1|删除成功！";
    }
}

 mysql_close($con);

?>
