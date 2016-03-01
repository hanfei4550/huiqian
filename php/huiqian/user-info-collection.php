<html>
<?php
header("Content-Type: text/html; charset=utf-8");
$nick = "";
$userId = "";
$activityId = "";
$headImage = "";
if (is_array($_GET) && count($_GET) > 0)//判断是否有Get参数
{
    if (isset($_GET["nick"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $nick = urldecode($_GET['nick']);//存在
    }
    if (isset($_GET["userId"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $userId = $_GET['userId'];//存在
    }
    if (isset($_GET["activityId"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $activityId = $_GET['activityId'];//存在
    }
    if (isset($_GET["headImage"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $headImage = $_GET['headImage'];//存在
    }
}
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <link rel="stylesheet" type="text/css" href="css/public.css">
    <title>会签—会议签到</title>
</head>
<body youdao="bind">
<div class="swiper-container p_box swiper-container-horizontal">
    <ul id="top_play" class="swiper-wrapper"
        style="transition-duration: 0ms; transform: translate3d(-5396px, 0px, 0px);">
        <li class="swiper-slide swiper-slide-duplicate" data-swiper-slide-index="2" style="width: 1349px;"><a
                href="http://www.youku.com/"><img src="images/tmp2.jpg"></a></li>
        <li class="swiper-slide" data-swiper-slide-index="0" style="width: 1349px;"><a
                href="https://www.baidu.com/"><img src="images/tmp2.jpg"></a></li>
        <li class="swiper-slide" data-swiper-slide-index="1" style="width: 1349px;"><a href="http://www.qq.com/"><img
                    src="images/tmp2.jpg"></a></li>
        <li class="swiper-slide swiper-slide-prev" data-swiper-slide-index="2" style="width: 1349px;"><a
                href="http://www.youku.com/"><img src="images/tmp2.jpg"></a></li>
        <li class="swiper-slide swiper-slide-duplicate swiper-slide-active" data-swiper-slide-index="0"
            style="width: 1349px;"><a href="https://www.baidu.com/"><img src="images/tmp2.jpg"></a></li>
    </ul>
    <div class="swiper-pagination pager swiper-pagination-clickable" id="pager"><span
            class="swiper-pagination-bullet swiper-pagination-bullet-active"></span><span
            class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet"></span></div>
</div>
<form id="userinfoForm" method="post" action="UserService.php">
    <div class="login_box">
        <div class="l_ipt">
            <i class="i_cn"></i>
            <input type="text" name="name" placeholder="请输入您的姓名" class="txt" tabindex="1">

            <div class="clear"></div>
            <label class="err_tips">*输入不能为空</label>
        </div>
        <div class="l_ipt">
            <i class="i_cp"></i>
            <input type="tel" name="phone" placeholder="请输入您的手机号" class="txt" tabindex="2">

            <div class="clear"></div>
            <label class="err_tips">*输入不能为空</label>
        </div>
        <center><a href="###" class="sub_btn">提交</a></center>
    </div>
    <input type="hidden" name="nick" value="<?php echo $nick ?>"/>
    <input type="hidden" name="userId" value="<?php echo $userId ?>"/>
    <input type="hidden" name="activityId" value="<?php echo $activityId ?>"/>
    <input type="hidden" name="headImage" value="<?php echo $headImage ?>"/>
</form>
<p class="ft_cp">技术支持：会签客</p>
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="js/swiper.min.js"></script>
<script>
    $(function () {
        var swiper = new Swiper('.swiper-container', {
            pagination: '.swiper-pagination',
            paginationClickable: true,
            autoplay: 3000,
            loop: true
        });

        //表单验证
        var phone_reg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
        $(".sub_btn").click(function () {
            if ($("input[name=name]").val() == '') {
                $("input[name=name]").siblings("label").fadeIn().fadeOut().fadeIn();
                return false;
            } else {
                $("input[name=name]").siblings("label").hide();
            }
            if ($("input[name=phone]").val() == '') {
                $("input[name=phone]").siblings("label").fadeIn().fadeOut().fadeIn();
                return false;
            } else {
                if (!phone_reg.test($("input[name=phone]").val())) {
                    $("input[name=phone]").siblings("label").text("*请输入正确的手机号码").fadeIn().fadeOut().fadeIn();
                    return false;
                } else {
                    $("input[name=phone]").siblings("label").hide();
                }
            }
            $("#userinfoForm").submit();
        })
    });
</script>

</body>
</html>