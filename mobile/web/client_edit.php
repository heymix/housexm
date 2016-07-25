<?php 
$action =$_GET["action"];
include '../config/config.php';
mysql_select_db($db_name, $con);          //选择数据库
mysql_query($char_set);
if ($action=="edit"){
 $id=$_GET["id"];    
    if(is_numeric($id)){
        
        $Query = "select * from t_client where is_del=0 and id=$id";
        $result     = mysql_query($Query);
        $rs     = mysql_fetch_array($result);
        if(!$rs){die("0|Valid result!"); mysql_close($con);}
        $projectId = $rs["project_id"];
        $name = $rs["name"];
        $tel =$rs["tel"];
        var_dump($Query);

        var_dump($rs);
    }else{
        echo "错误:入参非法";
        return false;
    }
    
}else{
    $action="save";
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width" /> 
<link rel="stylesheet" href="../jquery/jquery.mobile-1.3.2.min.css">
<script src="../jquery/jquery-1.8.3.min.js"></script>
<script src="../jquery/jquery.mobile-1.3.2.min.js"></script>

<script language="javascript">
$(document).ready(function(){

})

	function submitForm(){
			//alert("ddd");
			

			if($("#name").val().length==0){
				$("#errMsg").html('姓名不能为空！');
				return false;
			}
			if($("#tel").val().length==0){
				$("#errMsg").html('手号码不能为空！');
				return false;
			}
		
		$("#errMsg").html('正在提交请稍后....！');
		
			$.post(	"../lib/client_edit.php", 
				$("#editForm").serialize(), 
				function(data,st){
    				var resultArr=data.split("|");
    				$("#errMsg").html(resultArr[1]);
				});
		}
</script>

</head>
<body>

<div data-role="page" id="page1">


<?php include 'header.php';?>

  <div data-role="content">
  <p id="errMsg" style="color:#F00"></p>
  	<form id="editForm" name="editForm"  method="post" >
  	<?php if($action=='edit'){
  	echo "<input id='project' name='project' type='hidden' value='$projectId'>";
  	}
  	    ?>
  	项目: <select <?php if($action=='edit') echo "disabled";?>  name="project" id="project">
  	      <?php 
        	$q = "select * from t_project where is_del=0 order by id desc";                   //SQL查询语句
        	mysql_query($char_set);
        	$rs = mysql_query($q, $con);                     //获取数据集
        	//echo $q;
        	if(!$rs){die("Valid result!");}
        	
        	$i=0;
        	while($row = mysql_fetch_array($rs)) {
        	    if($row['id']==$projectId){
        	        $selected="selected";
        	    }else{
        	        $selected="";
        	    }
        	    echo"<option value='".$row['id']."' ".$selected.">".$row['name']."</option>\n";
        	}
        	?>
  </select>
  <input id="id" name="id" value="<?php echo $id?>" type=hidden>
  <input id="action" name="action" value="<?php echo $action?>" type=hidden>
	姓名: <input type="text" name="name" id="name" value="<?php echo $name;?>"/>
	电话: <input type="text" name="tel" id="tel" value="<?php echo $tel;?>" />
    <a href="#" data-role="button" onClick="submitForm();"><img src="../images/add.gif">保存</a>
	</form>
  </div>

<?php include 'footer.php';?>
</div> 


</body>
</html>
<?php mysql_close($con);?>