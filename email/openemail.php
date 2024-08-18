<?php
session_start();
$uname=$_SESSION['emailaddr']."@163.com";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <style type="text/css">
        body{margin: 0;}
        #div1{
            width: auto; height: auto;
            padding: 10px 0; margin: 0;
            background: #eef; border-bottom: 2px #aaf solid;
        }
        p{
            margin: 5px 0; padding: 0 10px;
            font-size: 10pt; line-height: 20px;
        }
        #div2{
            width: auto; height: auto;
            padding: 10px 0; margin: 0;
            border: 1px solid #a00;
        }
        #div2 p{text-indent: 2em;}
        #div3{
            width: auto; height: auto;
            padding: 0; margin: 0;
            border: 1px solid #aaf;
        }
        #div3 .p1{
            margin: 0; background: #eef; line-height: 40px;
        }
        #div3 .p2>img{
            width: 20px; height: 20px;
            margin-right: 10px;
            vertical-align: middle;
        }
    </style>
    <script src="jquery-1.11.3.min.js"></script>
    <script type="text/javascript">
        $(function(){
            var kzmArr= ['doc','docx','xls','xlsx','ppt','pptx', 'pdf','rar','txt','html','css','js','php','mp4'];
            var fileImg= ['doc.png','doc.png','xls.png','xls.png', 'ppt.png','ppt.png','pdf.jpg','rar.jpg','txt.jpg','html.jpg','css.jpg','js.jpg','mp4.jpg'];
            //遍历div3中类名为p2的段落
            $("#div3>.p2").each(function(){
                //获取段落的内容
                var pText=$(this).text();
                var fileNameArr=pText.split('(');
                fileNameArr.pop();
                //将fileNameArr中剩余部分使用左圆括号间隔连接起来
                var fileName=fileNameArr.join("(");
                var kzm=fileName.split('.').pop();
                //从数组kzmArr中查找kzm
                var kzmInd=kzmArr.indexOf(kzm);
                if(kzmInd != -1){
                    var tubiao = fileImg[kzmInd];
                    $(this).prepend("<img src='tubiao/" + tubiao + "'/>");
                }else{
                    $(this).prepend("<img src='upload/" + fileName + "'/>");
                }
            })

        })
    </script>
</head>
<body>
<?php
//获取超链接提交的邮件序号
$emailno=$_GET['emailno'];
$conn=mysqli_connect('127.0.0.1','root','ydj12345','email','3306');
$sql="select * from emailmsg where emailno={$emailno}";
$res=mysqli_query($conn, $sql);
$row=mysqli_fetch_array($res);
//判断附件信息列如果不为空，则获取附件个数
if($row['attachment'] != ''){
    $attach=explode(';',$row['attachment']);
    $attachCnt=count($attach)-1;
}
//输出div1及内部的邮件信息内容
echo"<div id='div1'>";
echo"<p><b>{$row['subject']}</b></p>";
echo"<p>发件人：{$row['sender']}</p>";
echo"<p>收件人：{$row['receiver']}</p>";
echo"<p>日期：{$row['datesorr']}</p>";
if($row['attachment'] != ''){
    echo"<p>附件：{$attachCnt}个</p>";
}
echo"</div>";
//输出div2及内部的邮件内容
echo"<div id='div2'><p>".str_replace(chr(13).chr(10), "<p>", $row['content'])."</div>";
//输出脚本代码判断并设置div2的高度
echo"<script>";
echo"var div2=document.getElementById('div2');";
echo"if(div2.clientHeight<200){div2.style.height='200px';}";
echo"</script>";
if($row['attachment'] != ''){
    echo "<div id='div3'>";
    echo"<p class='p1'>附件{$attachCnt}个</p>";
    for($i=0; $i<$attachCnt;$i++){
        //使用左圆括号分割附件名称信息
        $attName = explode("(",$attach[$i]);
        $attachName ="";
        for($j=1; $j<count($attName)-1;$j++){
            $attachName="{$attachName}({$attName[$j]}";
        }
        echo"<p class='p2'>{$attach[$i]}<br />";
        echo"<a href='upload/{$attachName}'>下载</a>&nbsp;|&nbsp;<a href='upload/{$attachName}'>打开</a>";
    }
    echo "</div>";
}
//使用分号分割readflag列值
$readArr=explode(";",$row['readflag']);
$isin=in_array($uname, $readArr);
if(!$isin){
    $readflag=$row['readflag']."$uname;";
    $sql="update emailmsg set readflag='{$readflag}' where emailno={$emailno}";
    mysqli_query($conn,$sql);
}
mysqli_close($conn);
?>
</body>
</html>