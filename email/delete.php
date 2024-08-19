<?php
	// 引入配置文件
	include_once 'config.php';
	//获取复选框组提交的邮件序号信息
	$markup=$_POST['markup'];
	$cnt=count($markup);
	// 获取数据库连接
  	$conn = get_db_connection();
	//使用循环结构逐条处理
	for($i=0;$i<$cnt;$i++){
		//定义更新语句
		$sql="update emailmsg set deleted=1 where emailno={$markup[$i]}";
		mysqli_query($conn,$sql);
	}
	include"receiveemail.php";
	echo"<script>";
	echo"alert('已经将{$cnt}封邮件放入已删除文件夹中')";
	echo"</script>";
?>