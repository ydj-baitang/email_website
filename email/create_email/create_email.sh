#!/bin/bash

# 设置PHP脚本的路径
PHP_SCRIPT_PATH="create_email.php"

# 运行PHP脚本
php "$PHP_SCRIPT_PATH"

# 检查PHP脚本的执行状态
if [ $? -eq 0 ]; then
    echo "PHP脚本执行成功"
else
    echo "PHP脚本执行失败"
fi