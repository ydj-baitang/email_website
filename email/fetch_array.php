<?php
  	$conn = mysqli_connect('localhost','root','ydj12345', 'email');
  	$sql="select * from emailmsg where sender='wangaihua@163.com'";
  	if($res=mysqli_query($conn,$sql)){
  			echo "<table border='1' width='800' align='center'>";
				echo"<tr><th width='100'>邮件序号</th><th width='150'>发件人</th><th width='400'>收件人</th><th width='150'>主题</th></tr>"; 
				while($row=mysqli_fetch_array($res)){
						echo"<tr>";
						echo "<td height='40'>{$row['emailno']}</td>";
						echo "<td>{$row['sender']}</td>";
						echo "<td>{$row['receiver']}</td>";
						echo "<td>{$row['subject']}</td>";
						echo"</tr>";
				}
				echo"</table>";
  	}else{
  			echo "查询语句有误，请检查<br />";
  	}
  mysqli_close($conn);
?>