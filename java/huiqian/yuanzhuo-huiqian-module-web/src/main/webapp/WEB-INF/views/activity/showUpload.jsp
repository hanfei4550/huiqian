<%--
  Created by IntelliJ IDEA.
  User: hanfei
  Date: 16/4/20
  Time: 下午12:19
  To change this template use File | Settings | File Templates.
--%>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <%--<link href="<%=request.getContextPath()%>/static/css/default.css" rel="stylesheet">--%>
    <link href="<%=request.getContextPath()%>/static/css/fileinput.css" rel="stylesheet">

    <title>圆桌骑士-管理活动成员</title>
</head>
<body>
<div>
    <button type="button" class="btn btn-primary"
            onclick="window.location.href='<%=request.getContextPath()%>/activity/all.htmls?memberId=${sessionScope.user.id}'">
        返回
    </button>
</div>
<div class="page-header">
    <h2>上传活动${activityId}的参会人员列表</h2>
</div>
<form enctype="multipart/form-data" id="uploadForm">
    <input id="file_0" name="fansFile" class="file" type="file">
    <br>
    <button type="submit" class="btn btn-primary">提交</button>
    <button type="reset" class="btn btn-default">重置</button>
    <input type="hidden" name="activityId" value="${activityId}">
</form>
<hr>
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<%--<script src="//cdn.bootcss.com/backbone.js/1.2.3/backbone-min.js"></script>--%>
<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="<%=request.getContextPath()%>/static/js/fileinput.js"></script>
<script src="<%=request.getContextPath()%>/static/js/fileinput_locale_zh.js"></script>
<script>

    $("#file_0").fileinput({});

    $(document).ready(function () {
        $("#uploadForm").submit(function (event) {
            var formData = new FormData(this);
            event.preventDefault();
            $.ajax({
                url: '<%=request.getContextPath()%>/activity/member/upload.htmls',
                type: 'POST',
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.result == 'success') {
                        $.globalMessenger().post({
                            message: "上传成功",
                            hideAfter: 2
                        });
                    } else {
                        $.globalMessenger().post({
                            errorMessage: "上传失败",
                            hideAfter: 2
                        });
                    }
                },
                error: function () {
                    $.globalMessenger().post({
                        errorMessage: "上传失败",
                        hideAfter: 2
                    });
                }
            });
        });
    });
</script>
</body>
</html>
