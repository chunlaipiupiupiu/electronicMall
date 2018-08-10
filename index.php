<?php
include_once './lib/fun.php';
if ($login = checkLogin()) {
    $user = $_SESSION['user'];
}
//检查page参数
$page = isset($_GET['page'])?intval($_GET['page']):1;
//将page与1进行对比，取其中最大值，防止将page的值进行非法的修改
$page = max($page, 1);
//每页显示的条数
$pageSize = 6;
//page = 1 limit 0, 2
//page = 2 limit 2, 4
//page = 3 limit 4, 6
$offset = ($page-1)*$pageSize;

//数据库连接
$con = mysqli_connect('127.0.0.1', 'root', '', 'imooc_mall');
$sql = "SELECT COUNT('id') AS total FROM im_goods";
$obj = mysqli_query($con, $sql);
$result = mysqli_fetch_assoc($obj);
$total = isset($result['total']) ? $result['total'] : 0;
unset($sql,$obj, $result);
//按照id的从小到大，view的从大到小排序
$sql = "SELECT `id`,`name`,`pic`,`des` FROM `im_goods` ORDER BY `id` asc,`view` desc limit {$offset},{$pageSize} ";
$obj = mysqli_query($con, $sql);
$goods = array();
$k = 0;
while ($result = mysqli_fetch_assoc($obj)) {
    $goods[] = $result;
    //截去它的localhost
    $goods[$k]['pic'] = substr($goods[$k]['pic'], 10);
    $k++;
}
unset($k);
$pages =  pages($total, $page, $pageSize, 5);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>M-GALLARY|首页</title>
    <!-- <link rel="stylesheet" type="text/css" href="./static/css/common.css"/> -->
    <link rel="stylesheet" type="text/css" href="./static/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="./static/css/index.css"/>
</head>
<body>
<div class="header">
    <div class="logo f1">
        <img src="./static/image/logo.png">
    </div>
    <div class="auth fr">
        <ul>
            <?php if ($login): ?>
                <li><span>管理员: <?php echo $user['username']; ?></span></li>
                <li><a href="publish.php">发布</a></li>
                <li><a href="login_out.php">退出</a></li>
            <?php else: ?>
                <li><a href="login.php">登录</a></li>
                <li><a href="register.php">注册</a></li>
            <?php endif; ?>
        </ul>
    </div>
</div>
<div class="content">
    <div class="banner">
        <img class="banner-img" src="./static/image/welcome.png" width="732px" height="372" alt="图片描述">
    </div>
    <div class="img-content">
        <ul>
            <?php foreach ($goods as $v): ?>
            <li>
                <img class="img-li-fix" <?php echo 'src='.$v['pic'] ?> alt="<?php echo $v['name'] ?>">
                <div class="info">
                    <a href="detail.php?id=<?php echo $v['id'] ?>"><h3 class="img_title"><?php echo $v['name'] ?></h3></a>
                    <p>
                        <?php echo $v['des'] ?>
                    </p>
                    <div class="btn">
                        <a href="edit.php?id=<?php echo $v['id'] ?>" class="edit">编辑</a>
                        <a href="delete.php?id=<?php echo $v['id'] ?>" class="del">删除</a>
                    </div>
                </div>
            </li>
            <?php endforeach ?>
        </ul>
    </div>
    <?php echo $pages; ?>
</div>

<div class="footer">
    <p><span>M-GALLARY</span>©2017 POWERED BY IMOOC.INC</p>
</div>
</body>
<script src="./static/js/jquery-1.10.2.min.js"></script>
<script>
    $(function () {
        $('.del').on('click',function () {
            if(confirm('确认删除该画品吗?'))
            {
               window.location = $(this).attr('href');
            }
            return false;
        })
    })
</script>

</html>
