<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title></title>
		<style type="text/css">
			body{margin: 0; }
			.wshdiv{
				width: auto; height: 50px;
				padding: 10px 40px 0; margin: 0;
				border-bottom: 6px #aaf solid;
			}
			.wshdiv>.wshleft{
				width: auto; margin: 0;
				float: left;
				font-size: .9rem;
			}
			.wshdiv>.wshleft>.emailaddr{
				width: 150px; font-weight: bold;
				border: 0;outline: none;
			}
			.wshdiv>.wshleft>a{
				color: #555; text-decoration: none;
			}
			.wshdiv>.wshright{
				width: auto; margin: 0;
				float: right;
			}
			.wshdiv>.wshright>.search{
				height: 26px;
			}
			.bot{
				width: auto; height: auto;
				padding: 0; margin: 0;
			}
			.bot>#leftdiv{
				width: 200px; height: 600px;
				padding: 0; margin: 0;
				border-right: 1px solid #aaf;
				border-bottom: 1px solid #aaf;
				float: left;
			}
			.bot>#leftdiv>.leftdivtop{
				width: 100%; height: 40px;
				padding: 0; margin: 0;
			}
			.bot>#leftdiv>.leftdivbot{
				width: 160px; height: auto;
				padding-left:40px;
				margin: 10px 0;
				font-size:.9rem;
			}
			.bot>#leftdiv>.leftdivbot>p>a:link{
				color:#555; text-decoration: none;
			}
			.bot>#leftdiv>.leftdivbot>p>a:visited{
				color:#555; text-decoration: none;
			}
			.bot>#leftdiv>.leftdivbot>p>a:hover{
				color:#00f; text-decoration: underline;
			}
			.bot>.maindiv{
				width: auto; height: auto;
				float: left;
				border: 0px solid #f00;
			}
		</style>
		<script type="text/javascript">
			function iframeWidth(){
				var w=(document.body.clientWidth)||(document.documentElement.clientWidth);
				var iframeW=w-202;
				document.getElementById('main').width=iframeW;
			}
			window.onload=iframeWidth;
			window.onresize=iframeWidth;
			
			function iframeHeight(){
				var iframe1=document.getElementById('main');
				if(iframe1.contentWindow){
					var h=iframe1.contentWindow.document.body.offsetHeight;
				}
				else if(iframe1.contentDocument){
					var h=iframe1.contentDocument.documentElement.offsetHeight;
				}
				iframe1.height=h;

				var leftdiv=document.getElementById('leftdiv');
				if(h>600){
					leftdiv.style.height=h+"px";
				}else{
					leftdiv.style.height="600px";
				}
			}
			
		</script>
	</head>
	<body>
    <?php session_start();?>
		<div class="wshdiv">
			<div class="wshleft">
				<img src="../images/163logo.gif" align="middle"/>
				<span class="emailaddr" readonly="readonly"><?php echo $_SESSION["emailaddr"]."@163.com"; ?></span>
				<a href="#">邮箱</a>&nbsp;|&nbsp;
				<a href="#">帮助</a>&nbsp;|&nbsp;
				<a href="denglu-tab.html">退出</a>
			</div>
			<div class="wshright">
				<input class="search" placeholder="支持邮件全文搜索" /><img src="../images/search.png" align="top"  />
			</div>
		</div>
		<div class="bot">
			<div id="leftdiv">
				<div class="leftdivtop">
					<img usemap="#map" src="../images/writerecieve.jpg" border="0" />
					<map name="map">
    					<area shape="rect" coords="8,5,100,36" href="../receiveemail.php" target="main">
    					<area shape="rect" coords="101,6,192,36" href="../writeemail.php" target="main">
					</map>
				</div>
				<div class="leftdivbot">
					<p><a href="../receiveemail.php" target='main'>收件箱</a></p>
					<p><a href="#">草稿箱</a></p>
					<p><a href="#">已发送</a></p>
					<p><a href="../deletedemail.php" target='main'>已删除</a></p>
				</div>
			</div>
			<div class="maindiv"><iframe name="main" id="main" width="auto" height="auto" frameborder="0" src="../writeemail.php" scrolling="no" onload="iframeHeight()"></iframe></div>
		</div>
	</body>
</html>