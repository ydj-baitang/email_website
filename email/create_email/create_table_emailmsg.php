<?php
  $conn=mysqli_connect('127.0.0.1','root','ydj2345','email','3306');
  //定义建表的SQL语句
  $sql="create table emailmsg(";
  $sql=$sql."emailno int(10) auto_increment primary key not null,";
  $sql=$sql."sender varchar(30) not null,";
  $sql=$sql."receiver varchar(1000) not null,";
  $sql=$sql."subject varchar(200) not null,";
  $sql=$sql."content text,";
  $sql=$sql."datesorr datetime not null,";
  $sql=$sql."attachment varchar(1000),";
  $sql=$sql."deleted tinyint(1) default 0)";
  $sql=$sql."default charset=utf8";
  if(mysqli_query($conn,$sql)){
  	echo "数据表emailmsg创建成功<br />";
  }
  else{
  	echo "数据表emailmsg创建失败，请检查SQL语句<br />";
  }
  mysqli_close($conn);
?>