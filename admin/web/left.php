<?php session_start();

function checkStr($str){
    $strArr=explode(",",$str);
    $returnStr = false;
    foreach ($strArr as $v){
        if(strpos($_SESSION['power'], ",$v,")!==false){
            $returnStr = true;
            break;
        }
    }
    return $returnStr;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>左侧导航</title>
<style type="text/css">
<!--
body,form,div,img{
	margin: 0px;
	font-size: 12px;
	color: #1F4A65;
	padding: 0px;
	border:0px;
}
ul {list-style:none;margin:0px; margin:0px; padding:0px} 

.clear{clear: both;position: relative;left: 0px;}
.clear5{clear: both;position: relative;left: 0px; height:5px}
a:link {
	font-size: 12px;
	color: #06482a;
	text-decoration: none;

}
a:visited {
	font-size: 12px;
	color: #06482a;
	text-decoration: none;
}
a:hover {
	font-size: 12px;
	color: #FF0000;
	text-decoration: none;
}
a:active {
	font-size: 12px;
	color: #FF0000;
	text-decoration: none;
}
.leftMenu{}
.leftMenu li{margin-top:5px;position: relative;left: 20px;}
.leftMenu li ul li{
	margin-top:0px;
	left: 0px;
	background-image: url(../images/left_line.gif);
	background-repeat: no-repeat;
	background-position: 0px 0px;
}
.leftMenu li ul li a{
	left: 15px;
	position: relative;
}
.leftMenu li img{
	vertical-align: middle;
}
.leftMenu span{
	font-weight: bold;
	cursor: pointer;
	color: #333;
}
.leftMenu span img{
	margin-right:4px;
}
.leftMenu li ul li img{
	margin-right:4px;
}
-->
</style>
<script language="javascript" src="../inc/jquery-1.7.1.min.js"></script>
<script language="javascript">
$(document).ready(function() {
	for(i=0;i<=13;i++){
			$("#show"+i).css("display","none");
		}
	$("#show1").css("display","block");
});

function showmenu(list_num){
		for(i=0;i<=13;i++){
			$("#show"+i).css("display","none");
		}
	if($("#show"+list_num).css("display")=="none"){
			$("#show"+list_num).css("display","block");
		}else{
			$("#show"+list_num).css("display","none");
		}
}

</script>
</head>

<body>
<table width="177" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed">
      <tr>
        <td height="26" background="../images/main_21.gif">&nbsp;</td>
      </tr>
      <tr>
        <td height="80" style="background-image:url(../images/main_23.gif); background-repeat:repeat-x;"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="45"><div align="center"><a href="#"><img src="../images/main_26.gif" name="Image1" width="40" height="40" border="0" id="Image1" /></a></div></td>
            <td><div align="center"><a href="#"><img src="../images/main_28.gif" name="Image2" width="40" height="40" border="0" id="Image2" /></a></div></td>
            <td><div align="center"><a href="#"><img src="../images/main_31.gif" name="Image3" width="40" height="40" border="0" id="Image3"/></a></div></td>
          </tr>
          <tr>
            <td height="25"><div align="center" class="STYLE2"><a href="javascript:void(0)">系统管理</a></div></td>
            <td><div align="center" class="STYLE2"><a href="javascript:void(0)"  onclick="window.top.frames['mainFrame'].frames['main'].location = 'syslog.asp'">日志管理</a></div></td>
            <td><div align="center" class="STYLE2"><a href="javascript:void(0)">数据分析</a></div></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td  style="line-height:4px; background:url(../images/main_38.gif)">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
  		<td><div class="clear5"></div>
<ul class="leftMenu">
    
	<li><span onclick="showmenu(1)"><img src="../images/tool.gif" width="16" height="14" />基础信息</span>
		<ul id="show1">
		<?php if(checkStr("23")) {?>
        	<li><a href="javascript:void(0)" onclick="window.top.frames['mainFrame'].frames['main'].location = 'dict_list.php'"><img src="../images/add.gif" width="16" height="14" />数据字典</a></li>
        <?php }?>
        <?php if(checkStr("10,11,12")) {?>
         <li><a href="javascript:void(0)"  onclick="window.top.frames['mainFrame'].frames['main'].location = 'company_list.php'"><img src="../images/test.gif" width="16" height="15" />公司中介管理</a></li>
         <?php }?>
         <?php if(checkStr("13,14,15")) {?>
         <li><a href="javascript:void(0)"  onclick="window.top.frames['mainFrame'].frames['main'].location = 'project_list.php'"><img src="../images/test.gif" width="16" height="15" />项目管理</a></li>
         <?php }?>
         <?php if(checkStr("22")) {?>
         <li><a href="javascript:void(0)"  onclick="window.top.frames['mainFrame'].frames['main'].location = 'admin_list.php'"><img src="../images/test.gif" width="16" height="15" />管理员</a></li>
         <?php }?>
         <?php if(checkStr("31")) {?>
         <li><a href="javascript:void(0)"  onclick="window.top.frames['mainFrame'].frames['main'].location = 'role_list.php'"><img src="../images/test.gif" width="16" height="15" />角色管理</a></li>
         <?php }?>
         <?php if(checkStr("33,34")) {?>
         <li><a href="javascript:void(0)"  onclick="window.top.frames['mainFrame'].frames['main'].location = 'news_list.php'"><img src="../images/test.gif" width="16" height="15" />活动分享管理</a></li>
         <?php }?>
         <?php if(checkStr("36,37,38")) {?>
         <li><a href="javascript:void(0)"  onclick="window.top.frames['mainFrame'].frames['main'].location = 'news_client_list.php'"><img src="../images/test.gif" width="16" height="15" />活动客户查看</a></li>
        <?php }?>

        </ul>    
    </li>
  
    <li><span  onclick="showmenu(9)"><img src="../images/exam.gif" width="16" height="14" />销售管理</span>
		<ul id="show9">
         <?php if(checkStr("16,17,18")) {?>
			<li><a href="javascript:void(0)" onclick="window.top.frames['mainFrame'].frames['main'].location = 'employee_list.php'"><img src="../images/add.gif" width="16" height="14" />经纪人管理</a></li>
			<?php }?>
            <?php if(checkStr("19,20,21")) {?>
			<li><a href="javascript:void(0)" onclick="window.top.frames['mainFrame'].frames['main'].location = 'client_list.php'"><img src="../images/add.gif" width="16" height="14" />销售管理</a></li>
            <?php }?>
        </ul>    
    </li>


    <li ><span onclick="showmenu(3)"><img src="../images/home.gif" width="16" height="14" />统计分析</span>
		<ul id="show3">
		      <?php if(checkStr("24,25")) {?>
			<li><a href="javascript:void(0)" onclick="window.top.frames['mainFrame'].frames['main'].location = 'company_report.php'"><img src="../images/add.gif" width="16" height="14" />公司统计</a></li>
			<?php }?>
            <?php if(checkStr("26,27")) {?>
			<li><a href="javascript:void(0)" onclick="window.top.frames['mainFrame'].frames['main'].location = 'project_report.php'"><img src="../images/add.gif" width="16" height="14" />项目统计</a></li>
			<?php }?>
            <?php if(checkStr("28,29")) {?>
			<li><a href="javascript:void(0)" onclick="window.top.frames['mainFrame'].frames['main'].location = 'employee_report.php'"><img src="../images/add.gif" width="16" height="14" />经纪人统计</a></li>
            <?php }?>
        </ul>    
    </li>

</ul></td>
  </tr>
</table>

</body>
</html>
