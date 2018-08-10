<?php
//删除商品
include_once './lib/fun.php';
//校验登录
if (!checkLogin()) {
    msg(2, '请登录', 'login.php');
}
//校验url中商品id
$goodsId = isset($_GET['id'])||is_numeric($_GET['id'])?intval($_GET['id']):'';
//如果商品id不存在，跳转到商品列表
if (!$goodsId) {
    msg(2, '参数非法', 'index.php');
}
//根据商品id查询商品信息
//数据库连接
$con = mysqli_connect('127.0.0.1', 'root', '', 'imooc_mall');
$sql = "SELECT * FROM im_goods WHERE id = {$goodsId} LIMIT 1";
$obj = mysqli_query($con, $sql);
//当根据id查询商品信息为空，则跳转商品列表页面
if (!$goods = mysqli_fetch_assoc($obj)) {
    msg(2, '画品不存在', 'index.php');
}
unset($sql, $obj);
//删除操作
$sql = "DELETE FROM im_goods WHERE id = '{$goodsId}' LIMIT 1";
if ($result = mysqli_query($con, $sql)) {
    // mysqli_affected_rows();
    msg(1, '操作成功', 'index.php');
} else {
    msg(2, '操作失败', 'index.php');
}
//tips:实际的开发中，不会直接删除商品而是用status进行标记 1：正常操作 2：删除操作
