<!DOCTYPE html>
<html>
<?php
header("Content-Type: text/html; charset=GBK");
$nick = "";
if (is_array($_GET) && count($_GET) > 0)//判断是否有Get参数
{
    if (isset($_GET["nick"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $nick = urldecode($_GET['nick']);//存在
    }
}
?>
<head>
    <meta charset="GBK">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>用户信息</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<form method="post" action="UserService.php">
    <div class="banner jumbotron text-center">图片广告/活动主题/品牌展示</div>
    <div class="info">提交填写个人基本信息，完成会议签到</div>
    <div class="form-group">
        <label for="name">姓名:</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="姓名">
    </div>
    <div class="form-group">
        <label for="phone">手机号:</label>
        <input type="text" class="form-control" id="phone" name="phone" placeholder="手机号">
    </div>
    <button type="submit" class="btn btn-default center-block">提交</button>
    <footer class="footer text-center">
        <p>技术支持：会签客</p>
    </footer>
    <input type="hidden" name="nick" value="<?php echo $nick ?>"/>
</form>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>