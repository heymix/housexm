<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>广嘉汇众地产服务中心-登录</title>
<script language="javascript" src="inc/jquery-1.7.1.min.js"></script>
<script src="jquery/jquery.bgiframe.min.js" type="text/javascript" charset='utf-8'></script>
<script src="jquery/loading-min.js" type="text/javascript"  charset="UTF-8"></script>
<link href="jquery/skins/green.css" rel="stylesheet" />
<script src="jquery/jquery.artDialog.min.js"></script>
<script src="jquery/artDialog.ico.js"></script>

<script>
if(self!=top)
{
window.open(self.location,'_top');
} 
var loading;
$(document).ready(function()
{
	loading=new ol.loading({id:"table1"});
	
	
});
function loginCheck(){
		if($("#UserName").val()==""){
			alertWin('error','警告',"用户名不能为空！");
			return false;
			}
		if($("#PassWord").val()==""){
			alertWin('error','警告',"登录密码不能为空！");
			return false;
			}
		loading.show();
		$.post(	"lib/login_check.php", 
				$("#LogForm").serialize(), 
				function(data,st){
						var resultArr=data.split("|");
						if(resultArr[0]=="1"){
							alertWin('succeed','提示',resultArr[1]+' 等待系统自动跳转...');
							window.location="web/main.html";
						}
						else{
							alertWin('error','警告',resultArr[1]);
							loading.hide();
						}
						
				});
}
</script>
<style type="text/css">
<!--
body,form {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	overflow:hidden;
}
.STYLE3 {color: #528311; font-size: 12px; }
.STYLE4 {
	color: #42870a;
	font-size: 12px;
}

.ol_loading {
	width: 100%;
	height:31px;
	background: url( 'images/loading.gif' );
	background-repeat: no-repeat;
	background-position: center center;
	display:none;
	position:absolute;
	top:40%;
	left:0px;
}
.ol_loading_mask{
	height:100%;
	width:100%;
	position:absolute;
	top:0px;
	left:0px;
	background-color: #fff;
	opacity: 0.6;
	filter: alpha(opacity = 60);
	display:none;
}
.mTitle{
	font-size: 28px;
	font-weight: bold;
	position: absolute;
	top: 50px;
	font-family: "黑体";
}
-->
</style></head>

<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" id="table1">
  <tr>
    <td bgcolor="#e5f6cf">&nbsp;</td>
  </tr>
  <tr>
    <td height="608" background="images/login_03.gif"><table width="862" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="266" background="images/login_04.gif"><div id="LogStatus"  class="mTitle">广嘉汇众地产服务中心管理系统</div></td>
      </tr>
      <tr>
        <td height="94"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="424" height="94" background="images/login_06.gif">&nbsp;</td>
            <td width="183" background="images/login_07.gif"><form id="LogForm" action="" method="post"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="21%" height="30"><div align="center"><span class="STYLE3">用户</span></div></td>
                <td width="79%" height="30"><input id="UserName" type="text" name="UserName"  style="height:18px; width:130px; border:solid 1px #cadcb2; font-size:12px; color:#81b432;"  onKeyPress="if (event.keyCode==13) loginCheck();"></td>
              </tr>
              <tr>
                <td height="30"><div align="center"><span class="STYLE3">密码</span></div></td>
                <td height="30"><input id="PassWord" type="password" name="PassWord"  style="height:18px; width:130px; border:solid 1px #cadcb2; font-size:12px; color:#81b432;" onKeyPress="if (event.keyCode==13) loginCheck();"></td>
              </tr>
              <tr>
                <td height="30">&nbsp;</td>
                <td height="30"><img src="images/dl.gif" width="81" height="22" border="0" usemap="#Map"></td>
              </tr>
            </table></form></td>
            <td width="255" background="images/login_08.gif">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="247" valign="top" background="images/login_09.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="22%" height="30">&nbsp;</td>
            <td width="56%"><div align="right"><span class="STYLE3" style="display:inline-block; width:80px;"></span></div></td>
            <td width="22%">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="44%" height="20">&nbsp;</td>
                <td width="56%" class="STYLE4"></td>
              </tr>
            </table></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#a2d962">&nbsp;</td>
  </tr>
</table>

<map name="Map"><area id="log" shape="rect" coords="3,3,36,19" href="javascript:void(0);" onclick="loginCheck();"><area shape="rect" coords="40,3,78,18" href="javascript:void(0);"></map>


</body>
</html>
</head>
<body>

</body>
</html>