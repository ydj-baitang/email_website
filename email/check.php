<?php
header("Content-Type:application/json;charset=utf8");

// 引入数据库配置文件
include 'config.php';

try {
    // 使用面向对象的 mysqli 类进行数据库连接
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);

    // 检查连接是否成功
    if ($conn->connect_error) {
        throw new Exception("数据库连接失败: " . $conn->connect_error);
    }

    // 获取表单数据
    $emailaddr = $_POST['emailaddr'];

    // 使用预处理语句查询数据
    $sql = "SELECT * FROM usermsg WHERE emailaddr = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("s", $emailaddr);
        $stmt->execute();
        $result = $stmt->get_result();

        $rownum = $result->num_rows;

        if ($rownum == 1) {
            $response = array("exists" => true, "message" => "该账号已经存在，请重新注册");
        } else {
            $response = array("exists" => false, "message" => "邮箱可用");
        }

        $stmt->close();
    } else {
        $response = array("exists" => false, "message" => "预处理语句创建失败: " . $conn->error);
    }

    $conn->close();

} catch (Exception $e) {
    $response = array("exists" => false, "message" => "发生错误: " . $e->getMessage());
}

// 输出 JSON 格式的响应
echo json_encode($response);
?>