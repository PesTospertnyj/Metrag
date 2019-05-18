<?php
session_start();
$url = $_POST['str'];
$view=$_POST['view'];
$str = explode("?view=",$url);

$str1=explode("&",$str[1]);

$str1[0]=$view;

$str[1]=implode("&",$str1);
$url_new=implode("?view=",$str);
echo $url_new;
?>
