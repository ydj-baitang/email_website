##代码简介
适合个人练习代码能力的邮箱网站，代码主要实现了用户进行注册、登录、收发邮件和删除邮件功能。代码比较简单，很多功能没写全，但是练习一下代码还是很不错的

##windows下部署环境
1.前提：有能运行php、html、js、css编程工具，还有一个数据库。

2.直接克隆到本地git clone https://github.com/ydj-baitang/email_website.git

3.需要修改config.php文件中的数据库连接信息
运行脚本create_email.sh，既可以实现数据库的创建和表的创建。

最后运行index.php即可。

如果想在Ubuntu部署这个项目也是可以的

##需要安装apache2、php、mysql

1.安装apache2

sudo apt-get install apache2

2.安装php

sudo apt-get install php php-mysql php-curl php-gd php-mbstring php-xml php-xmlrpc php-soap php-intl php-zip libapache2-mod-php

3.安装mysql

sudo apt-get install mysql-server

设置数据库密码

ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '密码';

4.将项目克隆到/var/www/html目录下

git clone https://github.com/ydj-baitang/email_website.git

cd email_website

sudo mv email /var/www/html/email

5.需要修改create_email文件夹下的所有文件中的数据库连接信息。（即$conn = mysqli_connect('127.0.0.1', 'root', '数据库密码', '','3306');如果只是密码不符合就改成自己的密码）

5.还有就是修改denglu.php、zhuce.php、check.php、dalete.php、deletedchedi.php、deletedemail.php、email.php、fetch_array.php、get_rows_usermsg.php、openemail.php、receiveemail.php、storeemail.php、writeemail.php中的数据库连接信息。
运行脚本create_email.sh，既可以实现数据库的创建和表的创建。
./create_email.sh

6.浏览器访问http://localhost/email即可看到登陆界面
