<?php
include_once './lib/fun.php';
//开启session
session_start();
//释放user
unset($_SESSION['user']);
msg(1, '退出登录成功', 'index.php');
