<?php
// 包含数据库连接配置文件
include '../config.php'; // 确保路径正确

// 创建数据库连接
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);

// 检查连接是否成功
if (!$conn) {
    die("连接失败: " . mysqli_connect_error());
}

// 设置字符集
mysqli_set_charset($conn, 'utf8mb4');

// 定义建表的 SQL 语句
$sql = "CREATE TABLE emailmsg (
    emailno INT(10) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    sender VARCHAR(30) NOT NULL,
    receiver VARCHAR(1000) NOT NULL,
    subject VARCHAR(200) NOT NULL,
    content TEXT,
    datesorr DATETIME NOT NULL,
    attachment VARCHAR(1000),
    deleted TINYINT(1) DEFAULT 0
) DEFAULT CHARSET=utf8mb4";

// 执行 SQL 语句
if (mysqli_query($conn, $sql)) {
    echo "数据表 emailmsg 创建成功<br />";
} else {
    echo "数据表 emailmsg 创建失败: " . mysqli_error($conn) . "<br />";
}

// 关闭连接
mysqli_close($conn);
?>