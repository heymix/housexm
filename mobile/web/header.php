  <div data-role="header">
  <?php $tuiCode=$_COOKIE["userId"];?>
     <a href="#" onClick="window.history.go(-1);" data-role="button">返回</a><h1>广嘉汇众地产服务中心</h1>
     
     <a href="#menu" data-rel="popup" data-role="button">菜单</a>
  <div data-role="popup" id="menu" data-theme="a">
    <ul data-role="listview" data-theme="c" data-inset="true">
        <li data-role="divider" data-theme="a">菜单</li>
        <li><a href="#" onclick='window.location.href="../index.php"'>首页</a></li>
        <li><a href="#" onclick='window.location.href="client_edit.php"'>新增</a></li>
        <li><a href="#" onclick='window.location.href="client_list.php"'>查询</a></li>
        <li><a href="#" onclick='window.location.href="news_list.php"'>活动</a></li>
        <li><a href="#" onclick='window.location.href="news_client_list.php"'>活动客户</a></li>
        <li><a href="#" onclick="alert('<?php echo $tuiCode;?>');">我的服务代码</a></li>
        <li><a href="#" onclick='window.location.href="password_edit.php"'>修改密码</a></li>
        <li><a href="#" onclick='window.location.href="../index.php?action=logout"'>退出</a></li>
    </ul>
  </div>
  </div>