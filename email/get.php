<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
	</head>
	<body>
		<a href="get.php?data=123&city=jinan">点击运行get.php文件，同时提交数据</a>
		<?php
			if(isset($_GET['data'])){
				$data=$_GET['data'];
				$city=$_GET['city'];
  				echo "超链接提交的数据是$data ,$city";
				
			}
  			
		?>
	</body>
</html>
