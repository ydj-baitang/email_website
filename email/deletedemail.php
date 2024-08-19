<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<style type="text/css">
			body{margin: 0;}
			.div1{
				width: auto; height: 25px;
				padding: 0 10px; margin: 0;
				font-size: .9rem; line-height: 25px;
			}
			.div2{
				width: auto; height: auto;
				padding: 5px 20px; margin: 5px 0;
				background: #eee;
				border-bottom: 1px solid #aaf;
			}
			.div2>.div2-1{
				width: auto; height: auto;
				padding: 0px; margin: 0;
				float: left;
			}
			.div2>.div2-1>input{
				font-size:.9rem;
			}
			.div2>.div2-2{
				width: auto; height: auto;
				padding: 0px; margin: 0;
				float: right;
				font-size: .9rem; line-height: 25px;
			}
			.div2:after{content: ''; display: block; clear:both;}
			.div3{
				width: auto; height: auto;
				padding: 0; margin: 0;
			}
			.div3 .a1{
				color: #000; text-decoration: none; font-weight: bold;
			}
			.div3 a{
				color: #000; text-decoration: none; font-weight: normal;
			}
			.div3 table{width: 100%;}
			.div3 table td{
				height: 30px; font-size:10pt;
				border-bottom: 1px solid #aaf;
				vertical-align: middle;
			}
			.div3 table .td1{width: 30px;}
			.div3 table .td2{width: 150px;}
			.div3 table .td3{width: auto;}
			.div3 table .td4{width: 20px;}
			.div3 table .td5{width: 120px;}
		</style>
<script type="text/javascript" src="jquery-1.11.3.min.js"></script>
<script>
	window.onload=function(){
		var form = document.getElementsByTagName('form')[0];
		form.onsubmit=function(){
			var res=false;
			var markup = document.getElementsByName('markup[]');
			for(var i=0;i<markup.length;i++){
				if(markup[i].checked){
					res=true;
					break;
				}
			}
			if(res==false){
				alert("请选择邮件之后再点删除按钮");
				return false;
			}
		}
		var sel = document.getElementById('pagesize');
		sel.onchange=function(){
			window.open("./deletedemail.php?pagesize=" + this.value, "_self");
		}
		/*//获取总控制复选框元素
		var ctrl=document.getElementById('control');
		//定义ctrl点击事件对应的匿名函数
		ctrl.onclick=function(){
			//获取每条记录前面的复选框元素
			var mkup = document.getElementsByName('markup[]');
			for(var i=0;i<mkup.length;i++){
				mkup[i].checked=this.checked;
			}
		}*/
		$('#control').click(function(){
			$(".markup").prop("checked",this.checked);
		})
	}
</script>
	</head>
	<body>
	<?php
	session_start();
	include './config.php';
	$uname=$_SESSION['emailaddr']."@163.com";
	$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
	$sql="select * from emailmsg where (receiver like '$uname%' or receiver like '%;$uname%') and deleted=1";
	if($res=mysqli_query($conn,$sql)){
		$emailNum=mysqli_num_rows($res);
		$pagesize=isset($_GET['pagesize'])?$_GET['pagesize']:5;
		$pagecount=ceil($emailNum/$pagesize);
		$pageno=isset($_GET['pageno'])?$_GET['pageno']:1;
		$pagestart=($pageno-1)*$pagesize;
		$sql2=$sql." order by datesorr desc limit $pagestart,$pagesize";
		$res2=mysqli_query($conn,$sql2);
	}else{
		echo "查询语句有误，请检查<br />";
	}
	?>
	<form method="post" action="./deletedchedi.php">
		<div class="div1">
			<b>已删除邮件</b>(共<?php echo $emailNum; ?> 封)
			&nbsp;&nbsp;每页
			<select id="pagesize">
				<option>2</option>
				<option>3</option>
				<option>5</option>
				<option>8</option>
				<option>10</option>
			</select>
			封
		<?php
			echo "<script>";
			echo "document.getElementById('pagesize').value='$pagesize';";
			echo "</script>";
		?>
		</div>
		<div class="div2">
			<div class="div2-1">
				<input type="checkbox" id="control" />
				<input type="submit" value=" 彻底删除 "  />
				<input type="button" value=" 刷新 " onclick="window.open('./deletedemail.php' ,'_self')" />
			</div>
			<div class="div2-2">
			<?php 
				if($pagecount==0){
					echo "首页&nbsp;&nbsp;上页&nbsp;&nbsp;下页&nbsp;&nbsp;尾页";
				}else{
					if($pageno==1){
						echo"首页&nbsp;&nbsp;";
					}else{
						echo"<a href='deletedemail.php?pageno=1&pagesize=$pagesize'>首页</a>&nbsp;&nbsp;";
					}
					if($pageno==1){
						echo"上页&nbsp;&nbsp;";
					}else{
						$shangye=$pageno-1;
						echo"<a href='deletedemail.php?pageno=$shangye&pagesize=$pagesize'>上页</a>&nbsp;&nbsp;";
						//echo"<a href='deletedemail.php?pageno=".($pageno-1)."&pagesize=$pagesize'>上页</a>&nbsp;&nbsp;";
					}
					if($pageno==$pagecount){
						echo"下页&nbsp;&nbsp;";
					}else{
						$xiaye=$pageno+1;
						echo"<a href='deletedemail.php?pageno=$xiaye&pagesize=$pagesize'>下页</a>&nbsp;&nbsp;";
						//echo"<a href='deletedemail.php?pageno=".($pageno+1)."&pagesize=$pagesize'>下页</a>&nbsp;&nbsp;";
					}
					if($pageno==$pagecount){
						echo"尾页";
					}else{
						echo"<a href='deletedemail.php?pageno=$pagecount&pagesize=$pagesize'>尾页</a>";
					}

				}
			?>
			</div>
		</div>
		<div class="div3">
			<table cellspacing="0" cellpadding="0">
			<?php
				while($row=mysqli_fetch_array($res2)){
					list($uname1)=explode('@',$row['sender']);
					list($date)=explode(' ',$row['datesorr']);
					list($y,$m,$d)=explode('-',$date);
					$riqi="{$y}年{$m}月{$d}日";
					$emailno=$row['emailno'];
					$readArr=explode(';',$row['readflag']);
					$isin=in_array($uname,$readArr);
					echo "<tr>";
					echo "<td class='td1'><input type='checkbox' name='markup[]' class='markup' value='$emailno'/></td>";
					if($isin){
						echo"<td class='td2'><a href='openemail.php?emailno=$emailno'>$uname1</a></td>";
						echo"<td class='td3'><a href='openemail.php?emailno=$emailno'>$row[subject]</a></td>";
					}else{
						echo"<td class='td2'><a class='a1' href='openemail.php?emailno=$emailno'>$uname1</a></td>";
						echo"<td class='td3'><a class='a1' href='openemail.php?emailno=$emailno'>$row[subject]</a></td>";
					}

					if($row['attachment']==''){
						echo "<td class='td4'>&nbsp;</td>";
					}else{
						echo "<td class='td4'><img src='images/flag-1.jpg'/></td>";
					}
					echo "<td class='td5'>$riqi</td>";
					echo "</tr>";
				}
			?>
			</table>
		</div>
	</form>
	</body>
</html>
