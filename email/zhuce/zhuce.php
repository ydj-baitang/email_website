<?php
header("Content-Type:text/html;charset=utf8");
session_start();
include_once '../config.php';
// 获取表单数据
$emailaddr = $_POST['emailaddr'];
$psd = $_POST['psd1'];
$psd1 = md5($psd);
$phoneno = $_POST['phoneno'];
$useryzm = $_POST['useryzm'];
$yzmchar = $_SESSION['yzm'];
$zhucedate = date('Y-m-d H:i');

// 验证码验证
if (strtoupper($useryzm) == $yzmchar) {
    // 数据库连接
    $conn = get_db_connection();
    if (!$conn) {
        die("数据库连接失败: " . mysqli_connect_error());
    }

    // 检查邮箱地址是否已存在
    $checkSql = "SELECT * FROM usermsg WHERE emailaddr = ?";
    $checkStmt = mysqli_prepare($conn, $checkSql);
    mysqli_stmt_bind_param($checkStmt, "s", $emailaddr);
    mysqli_stmt_execute($checkStmt);
    $checkResult = mysqli_stmt_get_result($checkStmt);

    if (mysqli_num_rows($checkResult) > 0) {
        echo "该账号已经存在，请重新注册";
        echo "<script>setTimeout(function(){ window.location.href = '../denglu/denglu-tab.html'; }, 3000);</script>";
    } else {
        // 插入新用户数据
        $insertSql = "INSERT INTO usermsg (emailaddr, psd, phoneno, zhucedate) VALUES (?, ?, ?, ?)";
        $insertStmt = mysqli_prepare($conn, $insertSql);
        mysqli_stmt_bind_param($insertStmt, "ssss", $emailaddr, $psd1, $phoneno, $zhucedate);

        if (mysqli_stmt_execute($insertStmt)) {
            echo "尊敬的用户您好，您注册的信息如下。<br />";
            echo "<table border='1'>";
            echo "<tr><td>邮箱地址：</td><td>{$emailaddr}</td></tr>";
            echo "<tr><td>密码：</td><td>******</td></tr>";
            echo "<tr><td>手机号：</td><td>{$phoneno}</td></tr>";
            echo "</table>";
            echo "<script>window.setTimeout(function(){
                window.location.href = '../denglu/denglu-tab.html';
            }, 3000);</script>";
        } else {
            echo "注册失败，请重试。错误信息: " . mysqli_error($conn);
        }

        mysqli_stmt_close($insertStmt);
    }

    mysqli_stmt_close($checkStmt);
    mysqli_close($conn);
} else {
    include 'zhuce.html';
    echo "<script>";
    echo "document.getElementById('emailaddr').value='$emailaddr';";
    echo "document.getElementById('psd1').value='$psd';";
    echo "document.getElementById('psd2').value='$psd';";
    echo "document.getElementById('phoneno').value='$phoneno';";

    echo "document.getElementById('useryzm').placeholder= '验证码输入错误，请重新输入';";
    echo "document.getElementById('useryzm').className='inp';";
    echo "</script>";
}
?>
