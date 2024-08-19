<?php
session_start();
include '../config.php'; // 引入数据库配置文件
$emailaddr = $_POST['emailaddr'];
$_SESSION['emailaddr'] = $emailaddr;
$psd = md5($_POST['psd']);
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
mysqli_select_db($conn,'email');
$sql = "select * from usermsg where emailaddr = '{$emailaddr}' and psd ='{$psd}'";
$result = mysqli_query($conn,$sql);
$datanum = mysqli_num_rows($result);
if ($datanum == 0) {
    include 'denglu.html';
    echo "<script>";
    echo "document . getElementById('errormsg') . style . display = 'block';";
    echo "</script>";
}
else {
    include '../email.php';
}
mysqli_close($conn);