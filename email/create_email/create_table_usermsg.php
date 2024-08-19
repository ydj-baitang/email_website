<?php
header("Content-Type:text/html;charset=utf8");

// 包含数据库连接配置文件
include './create_email/config.php'; // 确保路径正确

// 创建数据库连接
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);

// 检查连接是否成功
if (!$conn) {
    die("错误编号是: " . mysqli_connect_errno() . "<br />错误信息是: " . mysqli_connect_error());
}

// 定义建表的 SQL 语句
$sql = "CREATE TABLE usermsg (
    emailaddr VARCHAR(18) NOT NULL PRIMARY KEY,
    psd VARCHAR(255) NOT NULL,
    phoneno VARCHAR(11),
    zhucedate DATETIME NOT NULL
) DEFAULT CHARSET=utf8mb4";

// 执行 SQL 语句
if (mysqli_query($conn, $sql)) {
    echo "数据表 usermsg 创建成功<br />";
} else {
    echo "数据表 usermsg 创建失败: " . mysqli_error($conn) . "<br />";
}

// 关闭连接
mysqli_close($conn);
?>