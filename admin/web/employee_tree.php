<?php 
$action =$_GET["action"];
include '../config/config.php';
mysql_select_db($db_name, $con);          //选择数据库
mysql_query($char_set);

 $id=$_GET["id"];    
    if(is_numeric($id)){
        $listSon = getSon($id); //调用函数
        $listParent = getParent($id); //调用函数
    }else{
        echo "错误:入参非法";
       exit;
    }
    
function getSon($id=0){
    global $con;
    global $char_set;
    mysql_query($char_set);
    $sql = "select concat(true_name,id) as name,id,user_name from t_employee where parent_id= $id";
    $result = mysql_query($sql,$con);//查询子类
    $arr = array();
    if($result && mysql_affected_rows()){//如果有子类
        while($rows=mysql_fetch_assoc($result)){ //循环记录集
             //调用函数，传入参数，继续查询下级
            if(getSon($rows['id'])!==NULL){
                $rows['children'] = getSon($rows['id']);
            }else{
                $rows['isParent'] =true;   
            }
            $arr[] = $rows; //组合数组
        }
        return $arr;
    }
}


function getParent($parentId=0){
    global $con;
    global $char_set;
    mysql_query($char_set);
    $sql = "select concat(true_name,id) as name,id,user_name,parent_id as parentId from t_employee where id= $parentId";
    $result = mysql_query($sql,$con);//查询子类
    $arr = array();
    if($result && mysql_affected_rows()){//如果有子类
        while($rows=mysql_fetch_assoc($result)){ //循环记录集
            //调用函数，传入参数，继续查询下级
            if(getParent($rows['parentId'])!==NULL){
                $rows['children'] = getParent($rows['parentId']);
            }else{
                $rows['isParent'] =true;
            }
            $arr[] = $rows; //组合数组
        }
        return $arr;
    }
}

?>

<!DOCTYPE html>
<HTML>
<HEAD>
	<TITLE> 关系树 </TITLE>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" href="../ztree/css/demo.css" type="text/css">
	<link rel="stylesheet" href="../ztree/css/zTreeStyle/zTreeStyle.css" type="text/css">
	<script type="text/javascript" src="../ztree/js/jquery-1.4.4.min.js"></script>
	<script type="text/javascript" src="../ztree/js/jquery.ztree.core.js"></script>
	<SCRIPT type="text/javascript">
		<!--
		var setting = {	};

		var zNodes =<?php print_r(json_encode($listSon,true)); ?>;

		var zNodesParent =<?php print_r(json_encode($listParent,true)); ?>;

		$(document).ready(function(){
			$.fn.zTree.init($("#treeSon"), setting, zNodes);
		});
		
		$(document).ready(function(){
			$.fn.zTree.init($("#treeDemo"), setting, zNodesParent);
		});
		
		//-->
	</SCRIPT>
</HEAD>

<BODY>
<h1>关系树</h1>
<div class="content_wrap">
        
	<div class="zTreeDemoBackground left">

		<ul id="treeSon" class="ztree"></ul>
	</div>
	<div class="right">

    	<div class="zTreeDemoBackground left">
    		<ul id="treeDemo" class="ztree"></ul>
    	</div>	
	</div>
</div>
</BODY>
</HTML>
<?php  mysql_close($con);?>
