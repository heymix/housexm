<?php include '../config/config.php';

$file = $_FILES['file'];//得到传输的数据
//得到文件名称
$name = $file['name'];
$type = strtolower(substr($name,strrpos($name,'.')+1)); //得到文件类型，并且都转化成小写
$allow_type = array('jpg','jpeg','gif','png'); //定义允许上传的类型
//判断文件类型是否被允许上传
if(!in_array($type, $allow_type)){
  //如果不被允许，则直接停止程序运行
  return ;
}
//判断是否是通过HTTP POST上传的
if(!is_uploaded_file($file['tmp_name'])){
  //如果不是通过HTTP POST上传的
  return ;
}

define('BASE_PATH',str_replace('\\','/',realpath(dirname(__FILE__).'/../../'))."/");
$viturlPath="upload/images/";
$upload_path = BASE_PATH.$viturlPath; //上传文件的存放路径
$fileName = time().substr($name, strpos($name, '.') ,strlen($name));
//开始移动文件到相应的文件夹
if(move_uploaded_file($file['tmp_name'],$upload_path.$fileName)){
     echo "上传成功!";
     echo "<script>";
     echo "     window.parent.document.getElementById('image').value='$fileName';";
      echo "     window.parent.document.getElementById('imageShow').setAttribute('src','../../$viturlPath$fileName');";
     echo "</script>";
}else{
  echo "上传失败!<a href='../web/upload.php'>返回</a>";
}

 mysql_close($con);
?>
