<?php
header("Content-Type:text/html;charset=utf8");
$conn=mysqli_connect('127.0.0.1','root','数据库密码',"email","3306");
if(!$conn){
    die("错误编号是:" .mysqli_connect_errno() . "br />错误信息是:" . mysqli_connect_error());
}
else {
    $sql = "select * from usermsg";
    if ( $res= mysqli_query($conn, $sql) ) {
        echo"查询数据表usermsg 成功<br />";
        $rows=mysqli_num_rows($res);
        echo "数据表usermsg 中的记录数为{$rows}<br />";
    }
    else {
        echo"查询语句有错误，查询没有成功<br />";
    }
}