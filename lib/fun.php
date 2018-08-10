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

/**
 * 检查用户登录
 * @return [type] [description]
 */
function checkLogin()
{
    //开启session
    session_start();
    //用户未登陆返回false
    if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
        return false;
    }
    return true;
}
/**
 * 根据page生成url
 * @param  [type] $page [description]
 * @param  string $url  [description]
 * @return [type]       [description]
 */

function pageUrl($page, $url='')
{
    $url = empty($url) ? getUrl() : $url;
    //查询url中是否存在问号
    $pos = strpos($url, '?');
    if ($pos === false) {
        $url .= '?page='.$page;
    } else {
        $queryString = substr($url, $pos+1);
        //解析queryString为数组
        parse_str($queryString, $queryArr);
        if (isset($queryArr['page'])) {
            unset($queryArr['page']);
        }
        $queryArr['page'] = $page;
        //将querryArr重新拼接成querrString
        $queryString = http_build_query($queryArr);
        $url = substr($url, 0, $pos). '?' . $queryString;
        // echo '<pre>';
        // var_dump($url);
        // echo '</pre>';
    }
    return $url;
}

/**
 * 获取当前url
 * @return string $url
 */
function getUrl()
{
    $url = '';
    $url .= $_SERVER['SERVER_PORT'] == 443 ? 'https://' : 'http://';
    $url .= $_SERVER['HTTP_HOST'];
    $url .= $_SERVER['REQUEST_URI'];
    return $url;
}

/**
 * 分页显示
 * @param  int  $total       数据总数
 * @param  int   $currentPage 当前页
 * @param  int   $pageSize    每页显示条数
 * @param  int   $show        显示按钮
 * @return string             按钮拼接
 */
function pages($total, $currentPage, $pageSize, $show=5)
{
    $pageStr = '';
    //仅当总数大于每页条数，才进行分页处理
    if ($total > $pageSize) {
        //获取总页数，向上取整
        $totalPage = ceil($total / $pageSize);
        //对当前页进行容错处理
        $currentPage = $currentPage>$total ? $totalPage : $currentPage;
        //分页起始页
        $from = max(1, $currentPage - intval($show/2));
        //分页结束页，这里进行分类处理
        if ($currentPage - intval($show/2) <= 0 && $totalPage>=$show) {
            $to = $show;
        } elseif ($currentPage - intval($show/2) <= 0 && $totalPage<$show) {
            $to = $totalPage;
        } elseif ($currentPage + intval($show/2) > $totalPage && $totalPage>=$show) {
            $from = $totalPage - $show + 1;
            $to = $totalPage;
        } elseif ($currentPage + intval($show/2) > $totalPage && $totalPage<$show) {
            $from = 1;
            $to = $totalPage;
        } else {
            $to = $currentPage + intval($show/2);
        }
        //开始pageStr的拼接
        $pageStr .= '<div class="page-nav">';
        $pageStr .= '<ul>';
        //当且仅当当前页大于1时，存在首页和上一页按钮
        if ($currentPage > 1) {
            $pageStr .= "<li><a href='".pageUrl(1)."'>首页</a></li>";
            $pageStr .= "<li><a href='".pageUrl($currentPage-1)."'>上一页</a></li>";
        }
        if ($from > 1) {
            $pageStr .= '<li>...</li>';
        }
        for ($i=$from; $i <= $to; $i++) {
            if ($i != $currentPage) {
                $pageStr .= "<li><a href='".pageUrl($i)."'>{$i}</a></li>";
            } else {
                $pageStr .= "<li><span class='curr-page'>{$i}</span></li>";
            }
        }
        if ($to < $totalPage) {
            $pageStr .= '<li>...</li>';
        }
        if ($currentPage < $totalPage) {
            $pageStr .= "<li><a href='".pageUrl($currentPage+1)."'>下一页</a></li>";
            $pageStr .= "<li><a href='".pageUrl($totalPage)."'>尾页</a></li>";
        }

        $pageStr .= '</ul>';
        $pageStr .= '</div>';
    }
    return $pageStr;
}
