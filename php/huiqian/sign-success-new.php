<!DOCTYPE html>
<html lang="zh-CN">
<?php
require_once "jssdk.php";
$jssdk = new JSSDK("wx613472cd2a425abd", "7c607d6e08247bd8a49d6d850703a059");
$signPackage = $jssdk->GetSignPackage();
$userInfo = array();
$isshare = false;
if (is_array($_GET) && count($_GET) > 0)//判断是否有Get参数
{
    if (isset($_GET["userInfo"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $userInfo = json_decode($_GET['userInfo'], true);//存在
    }
    if (isset($_GET["isshare"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $isshare = $_GET['isshare'];//存在
    }
    if ($userInfo['activityId'] == "23") {
        $title = "菁英时代";
    } else {
        $title = "会签";
    }
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title><?php echo $title ?></title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/sign-success-new1.css?t=20160505" rel="stylesheet">
    <style>
        #mobileMessage {
            height: 25%;
            position: absolute;
            z-index: 9999;
            overflow: hidden;
            line-height: 50px;
        }

        div.danmu-row {
            position: absolute;
            margin-top: 70%;
            padding: 5px;
            width: 150px;
            line-height: 18px;
            height: auto;
            border-radius: 10px;
            background-color: black;
            opacity: 0.5;
            filter: Alpha(opacity=50);
        }

        span.danmu-image {
            float: left;
            width: 20%;
            height: 30px;
            text-align: center;
        }

        span.danmu-image img {
            border-radius: 10px;
            height: 30px;
            width: 30px;
        }

        span.danmu-comment {
            padding-left: 10px;
            padding-right: 10px;
            color: white;
            font-weight: 100;
            float: left;
            width: 78%;
            height: auto;
            text-align: left;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }
    </style>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container main-content">
    <div id="mobileMessage" class="col-md-3 col-md-push-9 col-xs-7 col-xs-push-5">
    </div>
    <div class="sign-result-content">
        <div class="sign-result-space"></div>
        <div class="sign-result-image"><img class="img-responsive" src="<?php echo $userInfo['headImage'] ?>"/></div>
        <div class="sign-result-nick"><p
                style="font-size: 1em;color: rgb(255, 255, 255);"><?php echo $userInfo['nick'] ?></p></div>
        <div class="sign-result-text">
            <div class="row sign-result-desc">
                <div class="col-md-3 col-md-push-3 col-xs-5"
                     style="font-size: 1em;color: rgb(255, 255, 255);">签到
                </div>
            </div>
            <div class="row sign-result-desc">
                <div class="col-md-3 col-md-push-4 col-xs-5 col-xs-push-3"
                     style="font-size: 1em;color: rgb(255, 255, 255);">第<span
                        style="font-size: 3em;color: rgb(255, 255, 255);"><?php echo $userInfo['fansCount'] ?></span>位
                </div>
            </div>
            <!--<div class="row sign-result-desc">-->
            <!--<div class="col-md-3 col-md-push-5 col-xs-8 col-xs-push-3"-->
            <!--style="font-size:1em;color: rgb(255, 255, 255);">2015-12-12-->
            <!--10:12:12-->
            <!--</div>-->
            <!--</div>-->
        </div>
    </div>
    <div id="commentDiv" class="comment-content">
        <div class="row">
            <div class="col-md-2 col-md-push-4 col-xs-4 col-xs-push-1 btn-comment"><img class="img-responsive"
                                                                                        src="images/sign-danmu-bg1.png"
                                                                                        onclick="openComment();"
                    />
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal">
    <div class="comment-content-modal">
        <div class="modal-comment-space">
            <!--            <button type="button" class="close" data-dismiss="modal"-->
            <!--                    style="margin-right: 10px;font-size: 28px;"><span-->
            <!--                    aria-hidden="true">&times;</span></button>-->
        </div>
        <div>
            <textarea class="form-control modal-comment-content" rows="4" style="resize: none;" name="comment"
                      id="comment"></textarea>
            <label id="msg" style="width: 80%"></label>
        </div>
        <div class="modal-comment-operate">
            <!--            <button id="publishComment" type="button" class="btn btn-primary btn-lg btn-block">发送</button>-->
            <button type="button" id="pubComment" class="btn btn-primary btn-block" onclick="publishComment();">发送
            </button>
            <button type="button" class="btn btn-default btn-block" data-dismiss="modal">关闭</button>
        </div>
    </div>
</div>

<input type="hidden" id="nick" value="<?php echo $userInfo['nick'] ?>"/>
<input type="hidden" id="openid" value="<?php echo $userInfo['openid'] ?>"/>
<input type="hidden" id="headImage" value="<?php echo $userInfo['headImage'] ?>"/>
<input type="hidden" id="userId" value="<?php echo $userInfo['userId'] ?>"/>
<input type="hidden" id="activityId" value="<?php echo $userInfo['activityId'] ?>"/>
<input type="hidden" id="fansId" value="<?php echo $userInfo['fansId'] ?>"/>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<!--[if lt IE 8]>
<script src="//cdnjs.cloudflare.com/ajax/libs/json3/3.3.2/json3.min.js"></script>
<![endif]-->
<script src="js/socket.io.js"></script>
<script src="js/client.js"></script>
<script>
    $(function () {
//        $("#publishComment").on("click", function () {
//            publishComment();
//        });
        var isshare = '<?php echo $isshare ?>';
        if (isshare == "true") {
            $("#commentDiv").hide();
        }
        $('#myModal').on('shown.bs.modal', function () {
            $('#comment').focus(); //通过ID找到对应输入框，让其获得焦点
        });
        //setInterval(getMobileMessage, 5000);
        var nick = $("#nick").val();
        var headImage = $("#headImage").val();
        var openid = $("#openid").val();
        var activityId = $("#activityId").val();
        CHAT.init(nick, headImage, openid, activityId);

        var evt = "onorientationchange" in window ? "orientationchange" : "resize";
        window.addEventListener(evt, function () {
            alert("请使用竖屏显示.");
            //event.stopPropagation();
            //event.cancelBubble = true;
        }, false);
    });


    function openComment() {
        $("#msg").html("");
        $('#myModal').modal('show');
    }

    //    function getMobileMessage() {
    //        $.ajax({
    //            url: "MobileMessageController.php",
    //            data: {
    //                "userId": $("#userId").val(),
    //                "activityId": $("#activityId").val()
    //            },
    //            method: "get",
    //            dataType: "json",
    //            success: function (result) {
    //                $("#mobileMessage").empty();
    //                $.each(result, function (i, msg) {
    //                    var content = '<div class="row top"><div class="danmu-row"><span class="danmu-image"><img width="50" height="50" src="' + msg['headImage'] + '"/></span><span class="danmu-comment">' + msg['content'] + '</span></div></div>';
    //                    $("#mobileMessage").append(content);
    //                });
    //                setInterval(function () {
    //                    scrollComments();
    //                }, 1000);
    //            }
    //        });
    //    }

    //    function scrollComments() {
    //        var $self = $("#mobileMessage");
    //        var lineHeight = $self.find("div:first").height();
    //        $self.animate({"margin-top": -lineHeight + "px"}, 600, function () {
    //            $self.find("div:first").appendTo($self);
    //        })
    //    }

    function publishComment() {
        var comment = $("#comment").val();
        if (comment == '') {
            $("#msg").css("color", "red");
            $("#msg").css("text-align", "center");
            $("#msg").html("亲！评论的长度不能为空.");
            return false;
        }
        if (comment.length > 15) {
            $("#msg").css("color", "red");
            $("#msg").css("text-align", "center");
            $("#msg").html("亲！评论的长度不能超过15个字.");
            return false;
        }
        var nick = $("#nick").val();
        var openid = $("#openid").val();
        var userId = $("#userId").val();
        var activityId = $("#activityId").val();
        var headImage = $("#headImage").val();
        var fansId = $("#fansId").val();
        var obj = {
            encodeComment: encodeURIComponent(comment),
            comment: comment,
            nick: encodeURIComponent(nick),
            userId: userId,
            activityId: activityId,
            headImage: headImage,
            openid: openid,
            fansId: fansId
        };
        CHAT.submit(obj);
        $("#comment").val("");
        $('#myModal').modal('hide');
//        $.ajax({
//            "url": "MessageController.php",
//            "method": "get",
//            "data": {
//                "comment": $("#comment").val(),
//                "userId": $("#userId").val(),
//                "activityId": $("#activityId").val(),
//                "nick": $("#nick").val()
//            },
//            success: function () {
//                $("#comment").val("");
//                $('#myModal').modal('hide');
//            },
//            error: function () {
//                $('#myModal').modal('hide');
//            }
//        });
    }
</script>
</body>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
    /*
     * 注意：
     * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
     * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
     * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
     *
     * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
     * 邮箱地址：weixin-open@qq.com
     * 邮件主题：【微信JS-SDK反馈】具体问题
     * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
     */
    wx.config({
//        debug: true,
        appId: '<?php echo $signPackage["appId"];?>',
        timestamp: <?php echo $signPackage["timestamp"];?>,
        nonceStr: '<?php echo $signPackage["nonceStr"];?>',
        signature: '<?php echo $signPackage["signature"];?>',
        jsApiList: [
            // 所有要调用的 API 都要加到这个列表中
            'onMenuShareTimeline', 'onMenuShareAppMessage', 'onMenuShareQQ'
        ]
    });
    wx.ready(function () {
        // 在这里调用 API
        wx.onMenuShareTimeline({
            title: '会签,让会议更精彩', // 分享标题
            link: window.location.href + "&isshare=true", // 分享链接
//            imgUrl: '', // 分享图标
            success: function () {
                // 用户确认分享后执行的回调函数
                alert("分享成功");
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
                alert("取消分享");
            }
        });
        wx.onMenuShareAppMessage({
            title: '会签', // 分享标题
            desc: '让会议更精彩', // 分享描述
            link: window.location.href + "&isshare=true", // 分享链接
//            imgUrl: '', // 分享图标
//            type: '', // 分享类型,music、video或link，不填默认为link
//            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            success: function () {
                // 用户确认分享后执行的回调函数
                alert("分享成功");
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
                alert("取消分享");
            }
        });
    });
</script>
</html>