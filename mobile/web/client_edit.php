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
        $sex = $rs["sex"];
        $age = $rs["age"];
        $family = $rs["family"];
        $district = $rs["district"];
        $metro = $rs["metro"];
        $school_ext = $rs["school_ext"];
        $school = $rs["school"];
        $category = $rs["category"];
        $hope_area = $rs["hope_area"];
        $hot_type = $rs["hot_type"];
        $hope_price = $rs["hope_price"];
        $hope_total_price = $rs["hope_total_price"];
        $house_type = $rs["house_type"];
        $hot_business = $rs["hot_business"];
        $intention_ext = $rs["intention_ext"];
        $intention = $rs["intention"];
        //var_dump($Query);

    }else{
        echo "错误:入参非法";
        return false;
    }
    
}else{
    $action="save";
}


/**
 * 
 * @param unknown $title 标题
 * @param unknown $type 字典类型
 * @param unknown $cate input 类别
 * @param unknown $db_name 数据库名
 * @param unknown $con 连接数据库
 * @param unknown $char_set
 * @param unknown $dateStr 修改数据
 * @return string
 */
function checkbox($title,$type,$cate,$db_name,$con,$char_set,$dateStr){

    $nameArr="";
    if ($cate==""||$cate=="checkbox"){
        $cate="checkbox";
        $nameArr="[]";
    }else{
        $nameArr="";
    }
    mysql_select_db($db_name, $con);          //选择数据库
    $returnStr="";
    $q = "select * from t_dictionary where `type`='$type' order by order_id asc";                   //SQL查询语句
    mysql_query($char_set);
    $rs = mysql_query($q, $con);                     //获取数据集
    //echo $q;
    if(!$rs){die("Valid result!");}
    
    $returnStr.="<fieldset data-role='controlgroup'>\n";
    $returnStr.="<legend>".$title."：</legend>\n";
    $i=0;
    while($row = mysql_fetch_array($rs)) {
        $i=$i+1;
        $checked="";
        if($cate=="checkbox"){
            if(strpos($dateStr, ",".$row["value"].",") !== false){
                $checked="checked";
            }
        }
        if($cate=="radio"){
          if($row["value"]==$dateStr){
              $checked="checked";
          } 
        } 
        
        
        $returnStr.="<label for='$type$i'>".$row["name"]."</label>\n";
        $returnStr.="<input type='$cate' name='$type$nameArr' id='$type$i' value='".$row["value"]."' $checked>\n";
    }
    $returnStr.=" </fieldset>";
    return $returnStr;
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
			

	if($("#project").val().length==0){
		$("#errMsg").html('项目不能为空！');
		return false;
	}
    
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
    				alert(resultArr[1]);
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
  	      <option value="">众筹项目活动选择</option>
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
     <fieldset data-role="controlgroup">
      <legend>请选择您的性别：</legend>
        <label for="male">先生</label>
        <input type="radio" name="sex" id="male" value="男" <?php if($sex=="男") echo "checked"?>>
        <label for="female">女士</label>
        <input type="radio" name="sex" id="female" value="女" <?php if($sex=="女") echo "checked"?>>	
      </fieldset>
      <?php 
            echo checkbox("年龄","age","radio",$db_name,$con,$char_set,$age);
            echo checkbox("家庭人口结构","family","radio",$db_name,$con,$char_set,$family);
        	echo checkbox("区域","district","checkbox",$db_name,$con,$char_set,$district);
        	echo checkbox("地铁","metro","checkbox",$db_name,$con,$char_set,$metro);
        	echo "学校: <input type='text'' name='school_ext' id='school_ext' value='$school_ext'/>";
        	echo checkbox("学校","school","checkbox",$db_name,$con,$char_set,$school);
        	echo checkbox("类型","category","checkbox",$db_name,$con,$char_set,$category);
        	echo checkbox("面积","hope_area","checkbox",$db_name,$con,$char_set,$hope_area);
        	echo checkbox("热门","hot_type","checkbox",$db_name,$con,$char_set,$hot_type);
        	echo checkbox("单价","hope_price","checkbox",$db_name,$con,$char_set,$hope_price);
        	echo checkbox("总价","hope_total_price","checkbox",$db_name,$con,$char_set,$hope_total_price);
        	echo checkbox("户型","house_type","checkbox",$db_name,$con,$char_set,$house_type);
        	echo checkbox("热门商圈","hot_business","checkbox",$db_name,$con,$char_set,$hot_business);
        	echo "近期购买意向楼盘: <input type='text'' name='intention_ext' id='intention_ext' value='$intention_ext'/>";
        	echo checkbox("近期购买意向","intention","checkbox",$db_name,$con,$char_set,$intention);
        	?>
    <a href="#" data-role="button" onClick="submitForm();"><img src="../images/add.gif">保存</a>
	</form>
  </div>

<?php include 'footer.php';?>
</div> 


</body>
</html>
<?php mysql_close($con);?>