<?php
session_start();
session_destroy();
$url="../index.html";
if (isset($url)) 
{ 
Header("HTTP/1.1 303 See Other"); 
Header("Location: $url"); 
exit; //from www.w3sky.com 
} 
