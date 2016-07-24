<?php

$db_host		= 'localhost'; 
$db_name		= 'xm';
$db_user		= 'root';
$db_passwd	= '123456';
$char_set		='SET NAMES utf8';
date_default_timezone_set('PRC');//设置时区
$con = mysql_connect($db_host,$db_user,$db_passwd);
if (!$con){
  die('Could not connect: ' . mysql_error());
}
?>
