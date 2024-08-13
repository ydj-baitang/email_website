<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title></title>
		<style type="text/css">
			body{margin: 0;}
			.write {
			width: 120px;height: 20px;padding: 0;margin: 0;	background: url(images/writebg.JPG);font-size: 10pt;text-align: center;line-height: 20px;}
			.butdivsh,.butdivxia {width: auto;height: 28px;padding: 8px 10px 0;margin: 0;	background: #eee;}
			.butdivsh {	border-bottom: 1px solid #aaf;}
			.butdivxia {	border-top: 1px solid #aaf;}
			.butdivsh input,.butdivxia input{ height:25px; font-size:10pt; border:1px solid #aaf; border-radius: 5px;}
			.divcont{width:auto; height:auto; padding:0px; margin:10px 0; border: 0px solid #f00; /*overflow: hidden;*/ }
			/*.divcont:after{content:'';display: block;clear:both;}*/
			#wdiv{width:300px; height:auto; padding:0; margin:0; float:left;}
			#zhedie{width:10px; margin:0px 0; float:left; padding: 223px 0 0; height:60px; }
			#rdiv{width:200px; height: 504px; padding:0; margin:0; background:#eee; border:1px solid #ddd; float:left; }
			#wdiv table{/*与父元素同宽，左侧列内容不允许换行*/width:100%; table-layout: fixed;}
			#wdiv table td{font-size:10pt; vertical-align:top;}
			#wdiv table .td1{width:60px; text-align:right;}
			#wdiv table .td2{width:auto;}
			#sender{width:200px; height:25px; padding:0; margin:0 0 5px; border:0; font-size:12pt; line-height:25px; font-weight:bold; outline:none;}
			#receiver,#subject,#content{width:auto; padding:0; border:1px solid #aaf; font-size:12pt; line-height:25px;}
			#receiver,#subject{height:25px; margin:0 0 5px;}
			#content{height:350px; margin:0;}
			#clear{clear: both;}
			.inp::-webkit-input-placeholder{color:#f00;}
			.inp::-moz-placeholder{color:#f00;}
			.inp:-moz-placeholder{color:#f00;}
			.inp:-ms-input-placeholder{color:#f00;}
			/*附件相关的元素样式*/
			.attachmsg{width: auto; height: 25px; padding: 0; margin: 0;}
			.del{color: #00f; text-decoration: underline; cursor: pointer;}
			.td2 p{margin: 0px 0 5px; display: none;}
			.td2 #p1{display: block!important;}
			.add{color: #00f; text-decoration: underline; cursor: pointer; line-height: 30px;}
		</style>
		<script src="jquery-1.11.3.min.js"></script>
		<script>
			function validate(){
				//验证收件人文本框和主题文本框是否为空
				var receiver=document.getElementById('receiver');
				var receiver_val=receiver.value;
				if(receiver_val==''){
					receiver.placeholder="收件人信息必须要填写";
					receiver.className='inp';
					return false;
				}
				var subject = document.getElementById('subject');
				var subject_val=subject.value;
				if(subject_val==''){
					subject.placeholder="主题信息必须要填写";
					subject.className='inp';
					return false;
				}
			}

			function wdivWidth(){
				var winW = document.documentElement.offsetWidth;
				var wdiv = document.getElementById('wdiv');
				var rdiv = document.getElementById('rdiv');
				if(rdiv.style.display != 'none' ){
					var w = winW - 10 - 202;
				}else{
					var w = winW - 10;
				}
				/*if(rdiv.style.display =='none'){
					var w = winW - 10;
				}else{
					var w = winW - 10-202;
				}*/
				//为何不能使用下面两种形式
				/*if(rdiv.style.display == 'block' ){
					var w = winW - 10 - 202;
				}else{
					var w = winW - 10;
				}*/
				/*if(rdiv.style.display !='block'){
					var w = winW - 10;
				}else{
					var w = winW - 10-202;
				}*/
				document.getElementById('receiver').style.width=(w-62)+"px";
				document.getElementById('subject').style.width=(w-62)+"px";
				document.getElementById('content').style.width=(w-62)+"px";
				
				wdiv.style.width=w+"px";
			}
			//window.onload=wdivWidth;
			window.onresize=wdivWidth;
			//显示或者隐藏rdiv
			function showOrHideRdiv(){
				var rdiv=document.getElementById('rdiv');
				var zhedieImg = document.getElementById('zhedieImg');
				if(rdiv.style.display !='none'){
					rdiv.style.display = 'none';
					zhedieImg.src="images/zhedieleft.JPG";
				}else{
					rdiv.style.display = 'block';
					zhedieImg.src="images/zhedieright.JPG";
				}
			}
			//点击继续添加附件的功能函数
			function addAttach(){
				for(var i=2;i<=10;i++){
					if(document.getElementById('p'+i).style.display!='block'){
						document.getElementById('p'+i).style.display ='block';
						var rdiv=document.getElementById('rdiv');
						var rdivH=rdiv.clientHeight;
						rdiv.style.height=(rdivH+30)+"px";
						var zhedie =document.getElementById('zhedie');
						var zhediePT=(rdivH+30-60)/2;
						zhedie.style.paddingTop=zhediePT+"px";
						parent.iframeHeight();
						//parent.iframeWidth();
						break;
					}
				}
			}
			
window.onload=function(){
	wdivWidth();
	var zhedieImg = 	document.getElementById('zhedieImg');
	zhedieImg.onclick=function(){
		showOrHideRdiv();
		wdivWidth();
	}
	var form=document.getElementsByTagName('form')[0];
	form.onsubmit=function(){
		return validate();
	}
	//点击“继续添加附件”调用函数addAttach
	var add=document.getElementsByClassName('add')[0];
	add.onclick=addAttach;
	//获取“删除”元素，点击调用函数dele()
	var del=document.getElementsByClassName('del');
	//使用循环处理10个del元素
	for(let i=0; i<10;i++){
		del[i].onclick=function(){
			dele(i+1);
		}
	}
	//i=0时，del[0]点击时调用函数dele(1),i=1时，点击del[1]时，调用函数dele(2)，事实上，是循环自顾自的先执行完，变量i的值得到2，当我们点击任何一个删除时，得到的都是dele(2+1)也就是dele(3)
	/*for(var i=0;i<del.length;i++){
		(function(index){
			del[index].onclick=function(){
				dele(index+1);
			}
		})(i)
	}*/
	/*$("span.del").each(function(index){
		$(this).click(function(){
			$("span:has('input')").eq(index).html("<input type='file' class='attachmsg' name='f"+(index+1)+"'/>");
			if(index!=0){
				$("p").eq(index).hide();
				var rdivH=$("#rdiv").height();
				$("#rdiv").height(rdivH-30);
				$("#zhedie").css("padding-top",(rdivH-30-60)/2 + "px");
				parent.iframeHeight();
				parent.iframeWidth();
			}
		})
	})*/
}
			//定义删除附件的函数dele()
function dele(num){
	var sp=document.getElementById('sp'+num);
	sp.innerHTML="<input type='file' class='attachmsg' name='f"+num+"'/>";
	if(num != 1){
		var p = document.getElementById('p'+num);
		p.style.display='none';
		var rdiv=document.getElementById('rdiv');
		var rdivH=rdiv.clientHeight;
		rdiv.style.height=(rdivH-30)+"px";
		var zhedie=document.getElementById('zhedie');
		zhedie.style.paddingTop=(rdivH-30-60)/2+"px";
		parent.iframeHeight();
		parent.iframeWidth();
	}
}
		</script>
	</head>
	<body>
		<form method="post" enctype="multipart/form-data" action="storeemail.php" >
		<div class="write">写信</div>
		<div class="butdivsh">
			<input type="submit" value=" 发送 " />
			<input type="button" value=" 存草稿 " />
			<input type="button" value=" 预览 " />
			<input type="button" value=" 查字典 " />
			<input type="reset" value=" 取消 " />
		</div>
		<div class="divcont">
			<div id="wdiv">
				<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td class="td1">发件人：</td>
						<td class="td2"><input type="text" name="sender" id="sender" readonly="readonly" value="<?php echo $_SESSION['emailaddr'].'@163.com'; ?>" ></span></td>
					</tr>
					<tr>
						<td class="td1">收件人：</td>
						<td class="td2"><input type="text" name="receiver" id="receiver"></td>
					</tr>
					<tr>
						<td class="td1">主题：</td>
						<td class="td2"><input type="text" name="subject" id="subject"></td>
					</tr>
					<tr>
						<td class="td1">附件：</td>
						<td class="td2">
							<p id="p1"><span id="sp1"><input type="file" name="f1" class="attachmsg"/></span><span class="del" >删除</span></p>
							<p id="p2"><span id="sp2"><input type="file" name="f2" class="attachmsg"/></span><span class="del">删除</span></p>
							<p id="p3"><span id="sp3"><input type="file" name="f3" class="attachmsg"/></span><span class="del">删除</span></p>
							<p id="p4"><span id="sp4"><input type="file" name="f4" class="attachmsg"/></span><span class="del">删除</span></p>
							<p id="p5"><span id="sp5"><input type="file" name="f5" class="attachmsg"/></span><span class="del">删除</span></p>
							<p id="p6"><span id="sp6"><input type="file" name="f6" class="attachmsg"/></span><span class="del">删除</span></p>
							<p id="p7"><span id="sp7"><input type="file" name="f7" class="attachmsg"/></span><span class="del">删除</span></p>
							<p id="p8"><span id="sp8"><input type="file" name="f8" class="attachmsg"/></span><span class="del">删除</span></p>
							<p id="p9"><span id="sp9"><input type="file" name="f9" class="attachmsg"/></span><span class="del">删除</span></p>
							<p id="p10"><span id="sp10"><input type="file" name="f10" class="attachmsg"/></span><span class="del">删除</span></p>
							<span class="add" >继续添加附件</span>
						</td>
					</tr>
					<tr>
						<td class="td1">内容：</td>
						<td class="td2"><textarea name="content" id="content"></textarea></td>
					</tr>
				</table>
			</div>
			<div id="zhedie"><img src="images/zhedieright.JPG" id="zhedieImg" /></div>
			<div id="rdiv"></div>
			<div id="clear"></div>
		</div>
		
		<div class="butdivxia">
			<input type="submit" value=" 发送 " />
			<input type="button" value=" 存草稿 " />
			<input type="button" value=" 预览 " />
			<input type="button" value=" 查字典 " />
			<input type="reset" value=" 取消 " />
		</div>
		</form>
		
	</body>
</html>
