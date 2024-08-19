##代码简介
适合个人练习代码能力的邮箱网站，代码主要实现了用户进行注册、登录、收发邮件和删除邮件功能。代码比较简单，很多功能没写全，但是练习一下代码还是很不错的

##windows下部署环境
1.前提：有能运行php、html、js、css编程工具，还有一个数据库。

2.直接克隆到本地git clone https://github.com/ydj-baitang/email_website.git

3.修改create_email文件夹下的create_email.php文件中的数据库连接信息，执行create_email.php文件，即可创建数据库表和所需的初始数据。                        
   

4.需要修改config.php文件中的数据库连接信息，运行index.html文件，即可看到登陆界面。




如果想在Ubuntu部署这个项目也是可以的（此项目也可以在liunx、mac系统下部署）

##需要安装apache2、php、mysql

1.安装apache2

sudo apt-get install apache2

2.安装php

sudo apt-get install php php-mysql php-curl php-gd php-mbstring php-xml php-xmlrpc php-soap php-intl php-zip libapache2-mod-php

3.安装mysql

sudo apt-get install mysql-server

4.进入数据库，设置mysql密码

ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '密码';


5.将此项目项目克隆到/var/www/html目录下

git clone https://github.com/ydj-baitang/email_website.git

cd email_website

sudo mv email /var/www/html/email

6.创建所需的数据库

修改create_email文件夹下的create_email.php文件中的数据库连接信息。

cd /var/www/html/email/create_email

保存退出后运行脚本create_email.sh，既可以实现数据库表的创建，和所需数据库的创建。
suod chmod +x create_email.sh       
./create_email.sh

7.需要修改config.php文件中的数据库连接信息

6.浏览器访问http://localhost/email即可看到登陆界面

到此，部署完成。