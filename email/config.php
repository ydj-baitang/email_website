<?php
// config.php
define('DB_SERVER', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'ydj12345'); // 请替换为实际密码
define('DB_DATABASE', 'email');
define('DB_PORT', 3306);

function get_db_connection() {
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
    if (mysqli_connect_errno()) {
        die('连接数据库失败: ' . mysqli_connect_error());
    }
    return $conn;
}
?>