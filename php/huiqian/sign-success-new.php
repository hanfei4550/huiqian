<!DOCTYPE html>
<html lang="zh-CN">
<?php
$userInfo = array();
if (is_array($_GET) && count($_GET) > 0)//判断是否有Get参数
{
    if (isset($_GET["userInfo"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $userInfo = json_decode($_GET['userInfo'], true);//存在
    }
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0"/>
    <title>签到成功</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/sign-success-new1.css" rel="stylesheet">
    <style>
        #mobileMessage {
            height: 280px;
            position: absolute;
            z-index: 9999;
            overflow: hidden;
            line-height: 50px;
        }

        div.danmu-row {
            position: absolute;
            margin-top: 50%;
            width: 150px;
            height: 50px;
            border: 1px solid;
            border-radius: 10px;
            background-color: gray;
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
            padding-left: 2px;
            float: left;
            width: 78%;
            height: 30px;
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
    <div id="mobileMessage" class="col-md-3 col-md-push-9 col-xs-6 col-xs-push-6">
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
    <div class="comment-content">
        <div class="row">
            <div class="col-md-2 col-md-push-4 col-xs-4 col-xs-push-1 btn-comment"><img class="img-responsive"
                                                                                        src="images/sign-danmu-bg.png"
                                                                                        onclick="javascript:openComment();"/>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="comment-content-modal">
        <div class="modal-comment-space">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    style="margin-right: 10px;font-size: 28px;"><span
                    aria-hidden="true">&times;</span></button>
        </div>
        <div>
            <textarea class="form-control modal-comment-content" rows="4" style="resize: none;" name="comment"
                      id="comment"></textarea>
            <label id="msg" style="width: 80%"></label>
        </div>
        <div class="modal-comment-operate">
            <button type="button" class="btn btn-primary btn-lg btn-block" onclick="publishComment()">发送</button>
        </div>
    </div>
</div>
<input type="hidden" id="nick" value="<?php echo $userInfo['nick'] ?>"/>
<input type="hidden" id="headImage" value="<?php echo $userInfo['headImage'] ?>"/>
<input type="hidden" id="userId" value="<?php echo $userInfo['userId'] ?>"/>
<input type="hidden" id="activityId" value="<?php echo $userInfo['activityId'] ?>"/>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<!--[if lt IE 8]>
<script src="//cdnjs.cloudflare.com/ajax/libs/json3/3.3.2/json3.min.js"></script>
<![endif]-->
<script src="http://realtime.plhwin.com:3000/socket.io/socket.io.js"></script>
<script src="js/client.js"></script>
<script>
    $(function () {
        //setInterval(getMobileMessage, 5000);
        var nick = $("#nick").val();
        var headImage = $("#headImage").val();
        CHAT.init(nick, headImage);
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
        var userId = $("#userId").val();
        var activityId = $("#activityId").val();
        var headImage = $("#headImage").val();
        var obj = {
            comment: comment,
            nick: nick,
            userId: userId,
            activityId: activityId,
            headImage: headImage
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
</html>