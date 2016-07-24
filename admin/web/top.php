<?php session_start()?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.STYLE1 {
	color: #43860c;
	font-size: 12px;
}
-->
</style></head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed;">
  <tr>
    <td height="9" style="line-height:9px; background-image:url(../images/main_04.gif)"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="97" height="9" background="../images/main_01.gif">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="47" background="../images/main_09.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="38" height="47" background="../images/main_06.gif">&nbsp;</td>
        <td width="59"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="29" background="../images/main_07.gif">&nbsp;</td>
          </tr>
          <tr>
            <td height="18" background="../images/main_14.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed;">
              <tr>
                <td  style="width:1px;">&nbsp;</td>
                <td ><span class="STYLE1"><?php echo $_SESSION['userName'];?></span></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="155" background="../images/main_08.gif">&nbsp;</td>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="23" valign="bottom"><img src="../images/main_12.gif" width="367" height="23" border="0" usemap="#Map" /></td>
          </tr>
        </table></td>
        <td width="200" background="../images/main_11.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="11%" height="23">&nbsp;</td>
            <td width="89%" valign="bottom"><span class="STYLE1"><script language="javascript">
	var d = new Date()
	var vYear = d.getFullYear()
	var vMon = d.getMonth() + 1
	var vDay = d.getDate()
	var h = d.getHours(); 
	var m = d.getMinutes(); 
	var se = d.getSeconds(); 
	var todayWeek = new Array("星期天","星期一","星期二","星期三","星期四","星期五","星期六");
//s="日期："+vYear+"年"+(vMon<10 ? "0" + vMon : vMon)+"月"+(vDay<10 ? "0"+ vDay : vDay)+"日"+(h<10 ? "0"+ h : h)+(m<10 ? "0" + m : m)+(se<10 ? "0" +se : se);
s="日期："+vYear+"年"+(vMon<10 ? "0" + vMon : vMon)+"月"+(vDay<10 ? "0"+ vDay : vDay)+"日 "+todayWeek[d.getDay()];
document.write(s);//输出时间
</script></span></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="5" style="line-height:5px; background-image:url(../images/main_18.gif)"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="180" background="../images/main_16.gif"  style="line-height:5px;">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>

<map name="Map" id="Map"><area shape="rect" coords="3,1,49,22" href="javascript:void(0)" onclick="window.location.href='main.html'" /><area shape="rect" coords="52,2,95,21" href="javascript:void(0)" onclick="window.history.go(-1);" /><area shape="rect" coords="102,2,144,21" href="javascript:void(0)" onclick="window.history.go(1);" /><area shape="rect" coords="150,1,197,22" href="javascript:void(0)" onclick="window.top.frames['mainFrame'].frames['main'].location.reload()" /><area shape="rect" coords="210,2,304,20" href="javascript:void(0)" onclick="window.top.frames['mainFrame'].frames['main'].location = 'reset_password.asp'" /><area shape="rect" coords="314,1,361,23" href="../index.php?action=logout" /></map></body>
</html>
