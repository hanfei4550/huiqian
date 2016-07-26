<!DOCTYPE html>
<html lang="zh-CN">
<?php
header("Content-Type: text/html; charset=utf-8");
$nick = "";
$userId = "";
$activityId = "";
$headImage = "";
$isValidateUser = "";
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
    if (isset($_GET["isValidateUser"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $isValidateUser = $_GET['isValidateUser'];//存在
    }
    if ($activityId == "23") {
        $title = "菁英时代";
        $header_bg = "http://www.huiqian.me/huiqian/images/header_jingying_bg.png";
    } else {
        $title = "会签";
        $header_bg = "http://www.huiqian.me/huiqian/images/header_huiqian_bg.jpg";
    }
}
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title><?php echo $title ?></title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/user-info-new.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container-fluid">
    <div class="header">
        <div class="row">
            <!--            <div class="col-xs-12 header-bg">-->
            <!--            </div>-->
            <img src="<?php echo $header_bg ?>" width="100%"/>
        </div>
    </div>
    <div class="body clearfix" style="min-height: 400px;">
        <form id="userinfoForm" method="post" action="UserService.php">
            <div class="row text-center body-element hint">
                <div class="col-xs-1"></div>
                <div class="col-xs-10"><span><img src="images/hint.png" width="15px;"/></span><span>请完成签到,惊喜等着您.</span>
                </div>
                <div class="col-xs-1"></div>
            </div>
            <div class="row text-center body-element">
                <div class="col-xs-1"></div>
                <div class="col-xs-10">
                    <div class="input-group body-input-bg">
                        <span class="input-group-addon"><img
                                src="images/body-input-name-bg.png" height="20px;"/></span>
                        <input type="text" class="form-control input-lg" id="name" name="name" placeholder="输入您的姓名">
                        <!--                        <label class="err_tips">*输入不能为空</label>-->
                    </div>
                </div>
                <div class="col-xs-1"></div>
            </div>
            <div class="row text-center body-element">
                <div class="col-xs-1"></div>
                <div class="col-xs-10">
                    <div class="input-group body-input-bg">
                        <span class="input-group-addon"><img src="images/body-input-phone-bg.png"
                                                             height="20px;"/></span>
                        <input type="text"
                               class="form-control input-lg"
                               id="phone"
                               name="phone"
                               placeholder="输入11位手机号">
                        <!--                        <label class="err_tips">*输入不能为空</label>-->
                    </div>
                </div>
                <div class="col-xs-1"></div>
            </div>
            <div class="row text-center body-element">
                <div class="col-xs-1"></div>
                <div class="col-xs-10">
                    <div class="input-group body-input-bg">
                                                <span class="input-group-addon"><img src="images/company.png"
                                                                                     height="20px;"/></span>
                        <input type="text"
                               class="form-control input-lg"
                               id="company"
                               name="company"
                               placeholder="输入公司名称">
                    </div>
                </div>
                <div class="col-xs-1"></div>
            </div>
            <!--                        <div class="row text-center body-element">-->
            <!--                            <div class="col-xs-1"></div>-->
            <!--                            <div class="col-xs-10">-->
            <!--                                <div class="input-group body-input-bg">-->
            <!--                                    <span class="input-group-addon"><img src="images/job.png"-->
            <!--                                                                         height="20px;"/></span>-->
            <!--                                    <input type="text"-->
            <!--                                           class="form-control input-lg"-->
            <!--                                           id="job"-->
            <!--                                           name="job"-->
            <!--                                           placeholder="输入职务">-->
            <!--                                </div>-->
            <!--                            </div>-->
            <!--                            <div class="col-xs-1"></div>-->
            <!--                        </div>-->
            <div class="row text-center body-submit">
                <div class="col-xs-1"></div>
                <div class="col-xs-10">
                    <button type="button" name="btnSubmit" class="btn btn-primary center-block btn-lg"
                            style="width:100%">提交
                    </button>
                </div>
                <div class="col-xs-1"></div>
            </div>
            <input type="hidden" name="nick" value="<?php echo $nick ?>"/>
            <input type="hidden" name="userId" value="<?php echo $userId ?>"/>
            <input type="hidden" name="activityId" value="<?php echo $activityId ?>"/>
            <input type="hidden" name="headImage" value="<?php echo $headImage ?>"/>
            <input type="hidden" name="isValidateUser" value="<?php echo $isValidateUser ?>"/>
        </form>
    </div>
    <footer class="text-center">
        <p>技术支持：会签</p>
    </footer>
</div>

<!--<div id="emptyError" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog"-->
<!--     aria-labelledby="mySmallModalLabel">-->
<!--    <div class="modal-dialog modal-sm">-->
<!--        <div class="modal-content">-->
<!--            <div class="modal-header">-->
<!--                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span-->
<!--                        aria-hidden="true">&times;</span></button>-->
<!--            </div>-->
<!--            <div class="modal-body">-->
<!--                姓名或手机号不能为空-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!---->
<!--<div id="phoneError" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog"-->
<!--     aria-labelledby="mySmallModalLabel">-->
<!--    <div class="modal-dialog modal-sm">-->
<!--        <div class="modal-content">-->
<!--            <div class="modal-header">-->
<!--                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span-->
<!--                        aria-hidden="true">&times;</span></button>-->
<!--            </div>-->
<!--            <div class="modal-body">-->
<!--                手机号格式不正确-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.toaster.js"></script>
<script>
    $(function () {
        //表单验证
        var phone_reg = /^(((13[0-9]{1})|(17[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
        $("button[name='btnSubmit']").click(function () {
            if ($("input[name='name']").val() == '') {
//                $('#emptyError').modal('show');
                $.toaster({priority: 'info', title: '用户验证失败', message: '姓名不能为空.'});
                return false;
            }
            if ($("input[name='phone']").val() == '') {
                $.toaster({priority: 'info', title: '用户验证失败', message: '手机号不能为空.'});
                return false;
            }
            if ($("input[name='company']").val() == '') {
                $.toaster({priority: 'info', title: '用户验证失败', message: '公司名称不能为空.'});
                return false;
            }
//            if ($("input[name='job']").val() == '') {
//                $.toaster({priority: 'info', title: '用户验证失败', message: '职务不能为空.'});
//                return false;
//            }
            if (!phone_reg.test($("input[name='phone']").val())) {
                $.toaster({priority: 'info', title: '用户验证失败', message: '手机号格式不正确.'});
                return false;
            }
            var isValidateUser = '<?php echo $isValidateUser ?>';
            if (isValidateUser == "1") {
                var activityId = $("input[name='activityId']").val();
                var name = $("input[name='name']").val();
                var phone = $("input[name='phone']").val();
                $.ajax({
                    "url": "ActivityFansController.php",
                    "method": "get",
                    "data": {
                        "activityId": activityId,
                        "name": name,
                        "phone": phone
                    },
                    "dataType": "json",
                    success: function (data) {
                        if (data.isValid == true) {
                            $("#userinfoForm").submit();
                        } else {
//                        alert("用户信息不存在.");
                            $.toaster({priority: 'info', title: '用户验证失败', message: '用户不存在.'});
                            return false;
                        }
                    },
                    error: function () {
                        $.toaster({priority: 'info', title: '用户验证失败', message: '用户不存在.'});
//                    alert("用户信息不存在.");
                        return false;
                    }
                });
            } else {
                $("#userinfoForm").submit();
            }
        });
    });
</script>
</body>
</html>