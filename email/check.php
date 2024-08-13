<?php
header("Content-Type:application/json;charset=utf8");

// 获取表单数据
$emailaddr = $_POST['emailaddr'];

// 数据库连接
$conn = mysqli_connect('127.0.0.1', 'root', 'ydj12345', 'email', '3306');
if (!$conn) {
    die("数据库连接失败: " . mysqli_connect_error());
}

// 使用预处理语句查询数据
$sql = "SELECT * FROM usermsg WHERE emailaddr = ?";
$stmt = mysqli_prepare($conn, $sql);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $emailaddr);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $rownum = mysqli_num_rows($result);

    if ($rownum == 1) {
        $response = array("exists" => true, "message" => "该账号已经存在，请重新注册");
    } else {
        $response = array("exists" => false, "message" => "邮箱可用");
    }

    mysqli_stmt_close($stmt);
} else {
    $response = array("exists" => false, "message" => "预处理语句创建失败: " . mysqli_error($conn));
}

mysqli_close($conn);

echo json_encode($response);
?>

