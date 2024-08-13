<?php
  $attachment='';
  for($i=1;$i<=10;$i++){
  	$fname=$_FILES["f{$i}"]["name"];
	  if($fname!=''){
	  	$ftmpname=$_FILES["f{$i}"]["tmp_name"];
		  $fsize=round($_FILES["f{$i}"]["size"]/1024,2);
		  $num=rand(0,100000);
		  $fname="($num)$fname";
		  $fname1=iconv("utf-8",'gb2312',$fname);
		  move_uploaded_file($ftmpname, "upload/$fname1");
		  $attachment="$attachment$fname({$fsize}kB);";  
	  }
  }
  $sender=$_POST['sender'];
  $receiver=$_POST['receiver'];
  $subject=$_POST['subject'];
  $content=$_POST['content'];
  $datesorr=date("Y-m-d H:i");
  $conn = mysqli_connect('127.0.0.1','root','数据库密码', 'email','3306');
  $receiverAll=explode(";",$receiver);
  $receiver="";
  for($i=0;$i<count($receiverAll);$i++){
  	list($uname)=explode("@",$receiverAll[$i]);
	  $sql="select * from usermsg where emailaddr='{$uname}'";
	  $res=mysqli_query($conn,$sql);
	  $num=mysqli_num_rows($res);
	  if($num==0){
	  	//完成退信功能
	  	$senderTX="system";
		  $receiverTX=$sender;
		  $subjectTX="系统退信";
		  $contentTX="{$uname}不存在，产生退信";
		  $dateTX=date("Y-m-d H:i:s");
		  $sql="insert into emailmsg(sender,receiver,subject,content,datesorr) values('{$senderTX}','{$receiverTX}','{$subjectTX}','{$contentTX}','{$dateTX}')";
		  mysqli_query($conn,$sql);
		  echo"{$uname}不存在，产生退信<br/>";
	  }else{
	  	$receiver="{$receiver}{$uname}@163.com;";
	  }
  }
  if($receiver!=''){
  	$sql="insert into emailmsg(sender,receiver, subject, content, datesorr, attachment) values('{$sender}','{$receiver}','{$subject}', '{$content}','{$datesorr}', '{$attachment}')";
    if(mysqli_query($conn,$sql)){
  		echo "邮件发送成功<br />";
    }
	  else{
  		echo "邮件发送失败，请检查sql语句<br />";
    }
  }
  
  
  
  mysqli_close($conn);
?>