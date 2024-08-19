<?php
session_start();
include_once '../config.php';
$emailaddr = $_POST['emailaddr'];
$_SESSION['emailaddr'] = $emailaddr;
$psd = md5($_POST['psd']);
// 获取数据库连接
$conn = get_db_connection();
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