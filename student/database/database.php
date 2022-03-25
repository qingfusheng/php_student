<?php
global $serverLink;
$serverLink = mysqli_connect("localhost","student","this_is_the_password") or die("<script>alert('连接服务器失败!程序中断执行!')</script>");
echo "<script>console.log('连接数据库服务器成功！')</script>";
mysqli_query($serverLink, "set names 'utf-8'");
//mysqli_set_charset($serverLink, "utf8");
mysqli_select_db($serverLink, "student") or die("<script>alert('切换服务器失败！程序中断执行')</script>");
echo "<script>console.log('切换数据库成功！')</script>";
?>