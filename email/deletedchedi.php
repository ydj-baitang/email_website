<?php
  //引入数据库连接文件
  include_once 'config.php';
  //获取用户选择的复选框提交的邮件序号
  $markup=$_POST['markup'];
  $cnt=count($markup);
  // 获取数据库连接
  $conn = get_db_connection();
  //使用循环结构逐条删除邮件
  for($i=0; $i<$cnt;$i++){
  	//定义查询语句，查询指定序号的邮件
  	$sql="select * from emailmsg where emailno={$markup[$i]}";
		$res=mysqli_query($conn,$sql);
		$row=mysqli_fetch_array($res);
		if($row['attachment'] != ''){
			//使用分号分割附件信息列的内容
			$attachArr=explode(';',$row['attachment']);
			//使用循环结构逐个处理附件信息
			for($m=0; $m<count($attachArr)-1;$m++){
				//使用左圆括号分割当前附件信息
				$attach=explode('(',$attachArr[$m]);
				//使用循环结构将除最后大小部分之外的内容以左圆括号为间隔连接在一起
				$fileName="upload/";
				for($j=1;$j<count($attach)-1;$j++){
					$fileName="{$fileName}({$attach[$j]}";
				}
				//将附件名称中汉字的编码由utf-8转为GB2312
				$fileName=iconv("utf-8","gb2312",$fileName);
				unlink($fileName);
			}
		}
  	//定义删除语句删除邮件
  	$sql="delete from emailmsg where emailno={$markup[$i]}";
	 	mysqli_query($conn,$sql);
  }
  mysqli_close($conn);
  include "deletedemail.php";
  //输出脚本代码弹出消息框提示用户已删除的邮件数
  echo"<script>";
  echo"alert('成功删除{$cnt}封邮件')";
  echo"</script>";
?>