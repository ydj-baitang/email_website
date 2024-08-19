<?php

// 获取数据库连接信息
$conn = mysqli_connect('127.0.0.1', 'root', 'password', '','3306'); 

// 检查连接是否成功
if (!$conn) {
    die("连接失败: " . mysqli_connect_errno() . "<br />错误信息: " . mysqli_connect_error());
}

// 指定要创建的数据库名称
$db_name = 'email'; // 替换为你要创建的数据库名称

// 创建数据库的 SQL 语句
$sql_create_db = "CREATE DATABASE IF NOT EXISTS $db_name DEFAULT CHARACTER SET utf8";

// 执行创建数据库的 SQL 语句
if (mysqli_query($conn, $sql_create_db)) {
    echo "数据库 $db_name 创建成功<br />";
} else {
    die("创建数据库 $db_name 失败: " . mysqli_error($conn) . "<br />");
}

// 选择数据库
mysqli_select_db($conn, $db_name);

// 定义创建第一个表的 SQL 语句
$sql_create_table1 = "CREATE TABLE IF NOT EXISTS usermsg (
                        emailaddr VARCHAR(18) NOT NULL PRIMARY KEY,
                        psd VARCHAR(255) NOT NULL,
                        phoneno VARCHAR(11),
                        zhucedate DATETIME NOT NULL
                      )";

// 执行创建第一个表的 SQL 语句
if (mysqli_query($conn, $sql_create_table1)) {
    echo "数据表 usermsg 创建成功<br />";
} else {
    echo "创建数据表 usermsg 失败: " . mysqli_error($conn) . "<br />";
}

// 定义创建第二个表的 SQL 语句
$sql_create_table2 = "CREATE TABLE IF NOT EXISTS emailmsg (
                        emailno INT(10) AUTO_INCREMENT PRIMARY KEY NOT NULL,
                        sender VARCHAR(30) NOT NULL,
                        receiver VARCHAR(1000) NOT NULL,
                        subject VARCHAR(200) NOT NULL,
                        content TEXT,
                        datesorr DATETIME NOT NULL,
                        attachment VARCHAR(1000),
                        deleted TINYINT(1) DEFAULT 0
                      ) DEFAULT CHARSET=utf8";

// 执行创建第二个表的 SQL 语句
if (mysqli_query($conn, $sql_create_table2)) {
    echo "数据表 emailmsg 创建成功<br />";
} else {
    echo "创建数据表 emailmsg 失败: " . mysqli_error($conn) . "<br />";
}

// 关闭数据库连接
mysqli_close($conn);
?>