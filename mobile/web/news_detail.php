<?php include '../config/conn.php';

mysql_select_db($db_name, $con);          //选择数据库
mysql_query($char_set);

$userId=$_COOKIE["userId"];
$id=$_GET["id"];    
if(is_numeric($id)){
    
    $Query = "select * from t_promotion where  id=$id and is_del=0";
    $result     = mysql_query($Query);
    $rs     = mysql_fetch_array($result);
    if(!$rs){die("0|Valid result!"); mysql_close($con);}
    $id = $rs["id"];
    $title= $rs["title"];
    $desc = $rs["desc"];
    $image =$rs["image"];
    $category =$rs["category"];
    $content =$rs["content"];
   
       
}else{
    echo "错误:入参非法";
    return false;
}
    
?>  
<!DOCTYPE html>
<html>
<head>
<title><?php echo $title;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width" /> 
<link rel="stylesheet" href="../jquery/jquery.mobile-1.3.2.min.css">
<script src="../jquery/jquery-1.8.3.min.js"></script>
<script src="../jquery/jquery.mobile-1.3.2.min.js"></script>
</head>
<body>
<div data-role="page" id="page1">
  <div data-role="header">
  
     <a href="#" onClick='window.location.href="../reg.php?parentId=<?php echo $userId;?>"'data-role="button">注册会员</a><h1><?php echo $title;?></h1>
     <a href="#" onClick='window.location.href="../sign_up.php?promotionId=<?php echo $id;?>&parentId=<?php echo $userId;?>"' data-role="button">我要报名</a>
     
  </div>

  <div data-role="content">
  <a href="#" onClick='window.location.href="../sign_up.php?promotionId=<?php echo $id;?>&parentId=<?php echo $userId;?>"' data-role="button">了解详情</a>
            <?php echo $content;?>

  </div>

<?php include 'footer.php';?>
</div> 


</body>
</html>
<?php mysql_close($con);?>