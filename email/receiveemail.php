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
				width: auto;
				height: auto;
				padding: 0; margin: 0;
			}
			.div3 a{/*对阅读过的邮件，超链接要移除类名a1*/
				color: #000; text-decoration: none; font-weight: normal;
			}
			.div3 a.a1{/*后面对没有阅读过的邮件超链接引用类名a1*/
				color: #000; text-decoration: none; font-weight: bold;
			}
			.div3 table{width: 100%; /*table-layout: fixed;*/}
			.div3 table td{
				height: 30px; border-bottom: 1px solid #aaf;
				vertical-align: middle;
				font-size: 10pt;
			}
			.div3 table td.td1{width: 30px;}
			.div3 table td.td2{width: 150px;}
			.div3 table td.td3{width: auto;}
			.div3 table td.td4{width: 20px;}
			.div3 table td.td5{width: 120px;}
		</style>
		

	</head>
	<body>
	<?php
		session_start();
		include_once 'config.php';
		$uname = $_SESSION['emailaddr']."@163.com";
		$conn = get_db_connection();
		$sql="select * from emailmsg where (receiver like '{$uname}%' or receiver like '%;{$uname}%') and deleted=0";
		$res=mysqli_query($conn,$sql);
		$reccount=mysqli_num_rows($res);
		//获取用户提交的每页中的邮件数
		$pagesize=isset($_GET['pagesize'])?$_GET['pagesize']:5;
		//获取收件箱中的邮件总页数
		$pagecount=ceil($reccount/$pagesize);
		//获取将要显示的记录所在的页码
		$pageno=isset($_GET['pageno'])?$_GET['pageno']:1;	
		//计算当前页要获取的第一条记录的编号
		$pagestart = ($pageno - 1)*$pagesize;
		//定义查询语句，获取当前页中要显示的邮件
		$sql2 = $sql." order by datesorr desc limit {$pagestart},{$pagesize}";
		$res2 = mysqli_query($conn,$sql2);
	?>
	<script src="jquery-1.11.3.min.js"></script>	
	<form method="post" action="delete.php">
		<div class="div1">
			<b>收件箱</b>（共<?php echo $reccount; ?>封）
			每页<select id="pagesize">
                <option>1</option>
				<option>2</option>
				<option>3</option>
				<option>5</option>
				<option>8</option>
			</select>封
			<script>
				var sel = document.getElementById('pagesize');
				sel.onchange=function(){
					window.open("receiveemail.php?pagesize=" + this.value ,"_self");
				}
			</script>
			<?php
				echo "<script>";
				//echo "document.getElementById('pagesize').value='{$pagesize}';";
				echo "$('select').val({$pagesize});";
				echo "</script>";
			?>
		</div>
		<div class="div2">
			<div class="div2-1">
				<input type="checkbox" id="control" />
				<input type="submit" value=" 删除 "  />
				<input type="button" value=" 刷新 " onclick="window.open('receiveemail.php','_self')" />
			</div>
			<div class="div2-2">
                
				<?php
                if($pagecount==0){
                    echo"首页&nbsp;&nbsp;上页&nbsp;&nbsp;下页&nbsp;&nbsp;尾页";
                }else{
                    if($pageno==1){
                        echo"首页&nbsp;&nbsp;";
                    }else{
                        echo"<a href='receiveemail.php?pageno=1&pagesize={$pagesize}'>首页</a>&nbsp;&nbsp;";
                    }
                    if($pageno==1){
                        echo"上页&nbsp;&nbsp;";
                    }else{
                        $shangye=$pageno-1;
                        echo"<a href='receiveemail.php?pageno={$shangye}&pagesize={$pagesize}'>上页</a>&nbsp;&nbsp;";
                    }?>
                    <?php
                    if ($pageno-3>0) {
                        $a3=$pageno-3;
                        $pageschoose= "<a href='receiveemail.php?pageno={$a3}&pagesize={$pagesize}'>$a3</a>&nbsp;&nbsp;";
                    }
                    if ($pageno-2>0) {
                        $a2=$pageno-2;
                        $pageschoose .= "<a href='receiveemail.php?pageno={$a2}&pagesize={$pagesize}'>$a2</a>&nbsp;&nbsp;";
                    }
                    if ($pageno-1>0) {
                        $a1=$pageno-1;
                        $pageschoose .= "<a href='receiveemail.php?pageno={$a1}&pagesize={$pagesize}'>$a1</a>&nbsp;&nbsp;";
                    }
                    $pageschoose .= "<a>$pageno</a>";
                    if ($pageno+1<=$pagecount) {
                        $b1=$pageno+1;
                        $pageschoose .= "&nbsp;&nbsp;<a href='receiveemail.php?pageno={$b1}&pagesize={$pagesize}'>$b1</a>&nbsp;&nbsp;";
                    }
                    if ($pageno+2<=$pagecount) {
                        $b2=$pageno+2;
                        $pageschoose .= "<a href='receiveemail.php?pageno={$b2}&pagesize={$pagesize}'>$b2</a>&nbsp;&nbsp;";
                    }
                    if ($pageno+3<=$pagecount) {
                        $b3=$pageno+3;
                        $pageschoose .= "<a href='receiveemail.php?pageno={$b3}&pagesize={$pagesize}'>$b3</a>&nbsp;&nbsp;";
                    }
                    echo $pageschoose;
                    if($pageno==$pagecount){
                        echo"下页&nbsp;&nbsp;";
                    }else{
                        $xiaye=$pageno+1;
                        echo"<a href='receiveemail.php?pageno={$xiaye}&pagesize={$pagesize}'>下页</a>&nbsp;&nbsp;";
                    }
                    if($pageno==$pagecount){
                        echo"尾页";
                    }else{
                        echo"<a href='receiveemail.php?pageno={$pagecount}&pagesize={$pagesize}'>尾页</a>";
                    }
                }
                ?>
			</div>
		</div>
		<div class="div3">
			<table cellpadding="0" cellspacing="0">
			<?php
				//使用循环结构逐条获取查询结果记录集中的记录
				while($row=mysqli_fetch_array($res2)){
					//获取邮件序号保存在变量$emailno中
					$emailno = $row['emailno'];
					//从发件人账号中提取用户名信息
					list($sender)=explode('@',$row['sender']);
					//从收发日期信息中提取年月日
					list($date)=explode(' ',$row['datesorr']);
					list($y,$m,$d)=explode('-',$date);
					$riqi="{$y}年{$m}月{$d}日";
					//使用分号分割readflag列值
					$readArr = explode(';',$row['readflag']);
					$isin = in_array($uname, $readArr);
					echo "<tr>";
					echo "<td class='td1'><input type='checkbox' name='markup[]' class='checkbox' value='{$emailno}' /></td>";
					if($isin){
						echo "<td class='td2'><a href='openemail.php?emailno={$emailno}'>{$sender}</a></td>";
						echo "<td class='td3'><a href='openemail.php?emailno={$emailno}'>{$row['subject']}</a></td>";
					}else{
						echo "<td class='td2'><a class='a1' href='openemail.php?emailno={$emailno}'>{$sender}</a></td>";
						echo "<td class='td3'><a class='a1' href='openemail.php?emailno={$emailno}'>{$row['subject']}</a></td>";
					}
					if($row['attachment'] != ''){
						echo "<td class='td4'><img src='images/flag-1.jpg' /></td>";
					}else{
						echo "<td class='td4'>&nbsp;</td>";
					}
					echo "<td class='td5'>{$riqi}</td>";
					echo "</tr>";
				}
				mysqli_close($conn);
			?>	
			</table>
		</div>
	</form>
	
	<script type="text/javascript">
		/*//获取总控制复选框元素
		var ctrl=document.getElementById('control');
		ctrl.onclick=function(){
			//获取name为markup[]的复选框
			var mkup=document.getElementsByName('markup[]');
			//使用循环结构逐个处理
			for(var i = 0; i <mkup.length; i++){
				mkup[i].checked=this.checked;
			}
		}*/
		$("#control").click(function(){
			$(".checkbox").prop("checked",this.checked);
		})
		//获取form元素
		var form=document.getElementsByTagName('form')[0];
		//定义form的submit事件处理函数
		form.onsubmit=function(){
			var res=false;
			//获取markup[]复选框组
			var markup=document.getElementsByName('markup[]');
			//使用循环结构逐一判断是否存在被选中的复选框
			for(var i=0; i<markup.length; i++){
				if(markup[i].checked){
					res=true;
					break;
				}
			}
			//判断res变量的值
			if(res==false){
				alert("对不起，你没有选中要删除的邮件，删除操作无效");
				return false;
			}
		}
	</script>
	</body>
</html>
