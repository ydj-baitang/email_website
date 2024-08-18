#!/bin/bash

# 定义 PHP 文件
php_files=(
    "create_email/create_email.php"
    "create_email/create_table_emailmsg.php"
    "create_email/create_table_usermsg.php"
)

# 遍历每个 PHP 文件并顺序执行
for php_file in "${php_files[@]}"; do
    echo "Running $php_file..."
    php "$php_file"
    if [ $? -ne 0 ]; then
        echo "Error occurred while running $php_file"
        exit 1
    fi
done

echo "All PHP files have been executed in sequence."