<?php
//编辑商品
include_once './lib/fun.php';
//校验登录
if (!checkLogin()) {
    msg(2, '请登录', 'login.php');
}
//进行表单提交处理
if (!empty($_POST['name'])) {
    //数据库连接
    $con = mysqli_connect('127.0.0.1', 'root', '', 'imooc_mall');
    if (!$goodsId = intval($_POST['id'])) {
        msg(2, '参数非法', 'index.php');
    }
    //根据商品id来校验商品
    $sql = "SELECT * FROM im_goods WHERE id = {$goodsId} LIMIT 1";
    $obj = mysqli_query($con, $sql);
    //当根据id查询商品信息为空，则跳转商品列表页面
    if (!$goods = mysqli_fetch_assoc($obj)) {
        msg(2, '画品不存在', 'index.php');
    }
    //画品名称
    $name = mysqli_real_escape_string($con, trim($_POST['name']));
    //画品价格
    $price = intval($_POST['price']);
    //画品简介
    $des = mysqli_real_escape_string($con, trim($_POST['des']));
    //画品详情
    $content = mysqli_real_escape_string($con, trim($_POST['content']));
    //验证处理
    $nameLength = mb_strlen($name, 'utf-8');
    if ($nameLength<0 || $nameLength>30) {
        msg(2, '画品名应在1~30字符之内');
    }
    if ($price<0 || $price>999999999) {
        msg(2, '画品价格应该在1~999999999之内');
    }
    $desLength = mb_strlen($des, 'utf-8');
    if ($desLength<0 || $desLength>100) {
        msg(2, '画品简介应该在1~100字符之内');
    }
    if (empty($content)) {
        msg(2, '画品详情不能为空');
    }

    //更新数组
    $update = array(
      'name'=>$name,
      'price'=>$price,
      'des'=>$des,
      'content'=>$content
    );

    //仅当用户选择上传图片时，才对数据库中的图片进行更新处理
    if ($_FILES['file']['size'] > 0) {
        $pic = imgUpload($_FILES['file']);
        $update['pic'] = $pic;
    }

    //只更新被更改的信息
    foreach ($update as $k => $v) {
        //对应key相等则删除要更新的字段
        if ($goods[$k] == $v) {
            unset($update[$k]);
        }
    }
    //如果没有进行更新并提交了表单，那么就跳转回原编辑的页面
    if (empty($update)) {
        msg(1, '操作成功', 'edit.php?id='.$goodsId);
    }

    //更新sql处理
    $updateSql = '';
    foreach ($update as $k => $v) {
        $updateSql .= "{$k}='{$v}',";
    }
    //去除右边多余的逗号
    $updateSql = rtrim($updateSql, ',');
    //进行sql语句的拼装
    unset($sql, $obj, $result);
    $sql = "UPDATE im_goods SET {$updateSql} WHERE id = '{$goodsId}'";
    if ($result = mysqli_query($con, $sql)) {
        //mysqli_affected_rows();//影响函数
        msg(1, '操作成功', 'edit.php?id='.$goodsId);
    } else {
        msg(2, '操作失败', 'edit.php?id='.$goodsId);
    }
} else {
    msg(2, '路由非法', 'index.php');
}
