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
$pageSize = 2;
//page = 1 limit 0, 2
//page = 2 limit 2, 4
//page = 3 limit 4, 6
$offset = ($page-1)*$pageSize;

//数据库连接
$con = mysqli_connect('127.0.0.1', 'root', '', 'imooc_mall');
//按照id的从小到大，view的从大到小排序
$sql = "SELECT * FROM im_goods ORDER BY 'id' ASC, 'view' DESC LIMIT {$offset}, {$pageSize} ";
$obj = mysqli_query($con, $sql);
$goods = array();
while ($result = mysqli_fetch_assoc($obj)) {
    $goods = $result;
}
echo pages(20, $page, $pageSize, 5);
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
            <li>
                <img class="img-li-fix" src="./static/image/wumingnvlang.jpg" alt="">
                <div class="info">
                    <a href=""><h3 class="img_title">无名女郎</h3></a>
                    <p>
                       图片描述可以分为多种，一种是单一说明，就比如直接的告诉读者这篇文章要介绍什么样子的内容，一些配图可以分为含蓄类型的，这样的配图一般会 图片描述可以分为多种。
                    </p>
                    <div class="btn">
                        <a href="#" class="edit">编辑</a>
                        <a href="#" class="del">删除</a>
                    </div>
                </div>
            </li>
            <li>
                <img class="img-li-fix" src="./static/image/wumingnvlang.jpg" alt="">
                <div class="info">
                    <a href=""><h3 class="img_title">无名女郎</h3></a>
                    <p>
                       图片描述可以分为多种，一种是单一说明，就比如直接的告诉读者这篇文章要介绍什么样子的内容，一些配图可以分为含蓄类型的，这样的配图一般会 图片描述可以分为多种。
                    </p>
                    <div class="btn">
                        <a href="#" class="edit">编辑</a>
                        <a href="#" class="del">删除</a>
                    </div>
                </div>
            </li>
            <li>
                <img class="img-li-fix" src="./static/image/wumingnvlang.jpg" alt="">
                <div class="info">
                    <a href=""><h3 class="img_title">无名女郎</h3></a>
                    <p>
                       图片描述可以分为多种，一种是单一说明，就比如直接的告诉读者这篇文章要介绍什么样子的内容，一些配图可以分为含蓄类型的，这样的配图一般会 图片描述可以分为多种。
                    </p>
                    <div class="btn">
                        <a href="#" class="edit">编辑</a>
                        <a href="#" class="del">删除</a>
                    </div>
                </div>
            </li>
            <li>
                <img class="img-li-fix" src="./static/image/wumingnvlang.jpg" alt="">
                <div class="info">
                    <a href=""><h3 class="img_title">无名女郎</h3></a>
                    <p>
                       图片描述可以分为多种，一种是单一说明，就比如直接的告诉读者这篇文章要介绍什么样子的内容，一些配图可以分为含蓄类型的，这样的配图一般会 图片描述可以分为多种。
                    </p>
                    <div class="btn">
                        <a href="#" class="edit">编辑</a>
                        <a href="#" class="del">删除</a>
                    </div>
                </div>
            </li>
            <li>
                <img class="img-li-fix" src="./static/image/wumingnvlang.jpg" alt="">
                <div class="info">
                    <a href=""><h3 class="img_title">无名女郎</h3></a>
                    <p>
                       图片描述可以分为多种，一种是单一说明，就比如直接的告诉读者这篇文章要介绍什么样子的内容，一些配图可以分为含蓄类型的，这样的配图一般会 图片描述可以分为多种。
                    </p>
                    <div class="btn">
                        <a href="#" class="edit">编辑</a>
                        <a href="#" class="del">删除</a>
                    </div>
                </div>
            </li>
            <li>
                <img class="img-li-fix" src="./static/image/wumingnvlang.jpg" alt="">
                <div class="info">
                    <a href=""><h3 class="img_title">无名女郎</h3></a>
                    <p>
                       图片描述可以分为多种，一种是单一说明，就比如直接的告诉读者这篇文章要介绍什么样子的内容，一些配图可以分为含蓄类型的，这样的配图一般会 图片描述可以分为多种。
                    </p>
                    <div class="btn">
                        <a href="#" class="edit">编辑</a>
                        <a href="#" class="del">删除</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="page-nav">
        <ul>
            <li><a href="#">首页</a></li>
            <li><a href="#">上一页</a></li>
            <li>...</li>
            <li><a href="#">5</a></li>
            <li><a href="#">6</a></li>
            <li><span class="curr-page">7</span></li>
            <li><a href="#">8</a></li>
            <li><a href="#">9</a></li>
            <li>...</li>
            <li><a href="#">下一页</a></li>
            <li><a href="#">尾页</a></li>
        </ul>
    </div>
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
