<!DOCTYPE html>
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
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width,initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta content="yes" name="apple-mobile-web-app-capable"/>
    <meta content="black" name="apple-mobile-web-app-status-bar-style"/>
    <link href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/public.css">
    <style>
        #mobileMessage {
            position: absolute;
            z-index: 9999;
        }

        .top {
            margin-bottom: 10px;
        }

        div.danmu-row {
            float: right;
            width: 200px;
        }

        span.danmu-image {
            float: left;
            width: 20%;
            height: 30px;
            text-align: center;
        }

        span.danmu-comment {
            float: left;
            width: 78%;
            height: 50px;
            background-color: gray;
        }
    </style>
    <title>会签—签到成功！</title>
</head>
<body>
<div id="mobileMessage"></div>
<div class="u_info">
    <span class="u_face"><img src="<?php echo $userInfo['headImage'] ?>"/></span>
    <span class="u_name"><?php echo $userInfo['nick'] ?></span>
</div>
<div class="u_index">
    <i class="c_1"></i>
    <i class="c_2"></i>
    <i class="c_3"></i>
    <i class="c_4"></i>

    <p class="p1">尊敬的嘉宾：</p>

    <p class="p2">欢迎您第<b><?php echo $userInfo['fansCount'] ?></b>位签到！</p>
</div>
<div class="hq_set">
    <a href="###" class="s1"><i class="ico"></i><i class="il"></i>会议内容</a>
    <a href="###" class="s2"><i class="ico"></i><i class="il"></i>会议流程</a>
    <a href="###" class="s3" data-toggle="modal" data-target="#myModal"><i class="ico"></i><i class="il"></i>发表评论</a>
</div>

<!--<div class="row" style="margin-top: 10px;">
    <div class="col-md-4 col-xs-4"></div>
    <div class="col-md-8 col-xs-8">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">发表评论</button>
    </div>
</div>
 Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">发表评论</h4>
            </div>
            <div class="modal-body">
                <textarea class="form-control" rows="3" name="comment" id="comment"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="publishComment()">发表</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="nick" value="<?php echo $userInfo['nick'] ?>"/>

<p class="ft_cp">技术支持：会签客</p>
</body>
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="js/swiper.min.js"></script>
<script>
    $(function () {
        $(".hq_set a.s1 .il").height($(window).height() - $(".hq_set a.s1").offset().top - 66);
        $(".hq_set a.s2 .il").height($(window).height() - $(".hq_set a.s2").offset().top - 66);
        $(".hq_set a.s3 .il").height($(window).height() - $(".hq_set a.s3").offset().top - 66);
        setInterval(getMobileMessage, 5000);
    });

    function getMobileMessage() {
        $.ajax({
            url: "MobileMessageController.php",
            data: {
                "userId": 1,
                "activityId": 1
            },
            method: "get",
            dataType: "json",
            success: function (result) {
                $("#mobileMessage").empty();
                $.each(result, function (i, msg) {
                    var content = '<div class="row top"><div class="danmu-row"><span class="danmu-image"><img width="50" height="50" src="http://www.hn-coffeecat.cn/cmstest/images/huiqian/' + msg['headImage'] + '"/></span><span class="danmu-comment">' + msg['content'] + '</span></div></div>';
                    $("#mobileMessage").append(content);
                });
            }
        });
    }

    function publishComment() {
        $.ajax({
            "url": "MessageController.php",
            "method": "get",
            "data": {
                "comment": $("#comment").val(),
                "activityId": 1,
                "userId": 1,
                "nick": $("#nick").val()
            },
            success: function () {
                $("#comment").val("");
                $('#myModal').modal('hide');
            },
            error: function () {
                $('#myModal').modal('hide');
            }
        });
    }
</script>
</html>
