<?php
/**
 * 数据库连接初始化
 * @param   $host     端口
 * @param   $username 用户名
 * @param   $password 密码
 * @param   $dbName   数据表名
 * @return            连接
 */
function mysqlInit($host, $username, $password, $dbName)
{
    //数据库操作
    $con = mysqli_connect($host, $username, $password, $dbName);
    if (!$con) {
        return false;
    }
    //设置字符集
    mysqli_set_charset($con, 'utf8');
    return $con;
}


/**
 * 密码加密
 * @param  [type] $password [description]
 * @return [type]           [description]
 */
function createPassword($password)
{
    if (!$password) {
        return false;
    }
    return md5(md5($password).'IMOOC');
}


/**
 * 消息提示
 * @param  int $type 1:操作成功 2:操作失败
 * @param  [type] $msg  [description]
 * @param  [type] $url  [description]
 * @return [type]       [description]
 */
function msg($type, $msg=null, $url=null)
{
    $toUrl = "Location:msg.php?type={$type}";
    $toUrl .= $msg?"&msg={$msg}":"";
    $toUrl .= $url?"&url={$url}":"";
    header($toUrl);
    exit;
}

/**
 * 图像上传
 * @param  [type] $file [description]
 * @return [type]       imgUrl 图片的url
 */
function imgUpload($file)
{
    //检查上传文件是否合法
    if (!is_uploaded_file($file['tmp_name'])) {
        msg(2, '请上传符合规范的图片');
    }
    $type = $file['type'];
    if (!in_array($type, array("image/png", "image/gif", "image/jpeg"))) {
        msg(2, '请上传png,gif,jpeg格式的图像');
    }
    //上传目录
    $uploadPath = './static/file/';
    //上传目录url
    $uploadUrl = '/static/file/';
    //上传目录文件夹
    $fileDir = date('Y/md/', $_SERVER['REQUEST_TIME']);
    if (!is_dir($uploadPath.$fileDir)) {
        mkdir($uploadPath.$fileDir, 755, true);//可递归创建
    }
    //获取文件的扩展名
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    //上传图像名称
    $img = uniqid().mt_rand().'.'.$ext;
    //图形路径
  $imgPath = $uploadPath.$fileDir.$img;//物理地址
  $imgUrl = 'localhost'.$uploadUrl.$fileDir.$img;//url地址
  //操作失败，查看操作目录的权限
  if (!move_uploaded_file($file['tmp_name'], $imgPath)) {
      msg(2, '服务器繁忙，请稍后再试');
  }
    return $imgUrl;
}
