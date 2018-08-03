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
