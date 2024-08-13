<?php
session_start();
$emailaddr = $_POST['emailaddr'];
$_SESSION['emailaddr'] = $emailaddr;
$psd = md5($_POST['psd']);
$conn = mysqli_connect('127.0.0.1','root','数据库密码','','3306');
mysqli_select_db($conn,'email');
$sql = "select * from usermsg where emailaddr = '{$emailaddr}' and psd ='{$psd}'";
$result = mysqli_query($conn,$sql);
$datanum = mysqli_num_rows($result);
if ($datanum == 0) {
    include '登录.html';
    echo "<script>";
    echo "document . getElementById('errormsg') . style . display = 'block';";
    echo "</script>";
}
else {
    include 'email.php';
}
mysqli_close($conn);