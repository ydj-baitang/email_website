<?php
header("Content-Type:text/html;charset=utf-8");

// 包含数据库连接配置文件
include './create_email/config.php'; // 确保路径正确

// 确保数据库配置文件中有连接信息
if (!isset($conn)) {
    die("数据库连接未正确配置");
}

// 检查数据库连接是否成功
if (mysqli_connect_errno()) {
    die("连接数据库失败: " . mysqli_connect_error());
}

// 数据库名称
$db_name = 'email';

// 检查数据库是否已存在
$result = mysqli_query($conn, "SHOW DATABASES LIKE '{$db_name}'");
if ($result) {
    if (mysqli_num_rows($result) > 0) {
        echo "数据库 {$db_name} 已存在<br />";
    } else {
        // 创建数据库
        $sql = "CREATE DATABASE {$db_name} DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
        if (mysqli_query($conn, $sql)) {
            echo "成功创建数据库 {$db_name}<br />";
        } else {
            echo "创建数据库 {$db_name} 失败: " . mysqli_error($conn) . "<br />";
        }
    }
    mysqli_free_result($result);
} else {
    echo "检查数据库失败: " . mysqli_error($conn) . "<br />";
}

// 关闭连接
mysqli_close($conn);
?>