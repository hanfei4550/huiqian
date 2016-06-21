<%--
  Created by IntelliJ IDEA.
  User: hanfei
  Date: 16/5/16
  Time: 下午3:17
  To change this template use File | Settings | File Templates.
--%>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<html>
<head>
    <title>会签-活动管理-设置奖项</title>
    <%--<link href="<%=request.getContextPath()%>/static/css/activity/showDetail.css" rel="stylesheet"/>--%>
</head>
<body>
<div class="container">
    <h2>设置活动编号${model['activityId']}的用户${model['fans'].nick}的奖项</h2>

    <form id="activityForm" action="<%=request.getContextPath()%>/activity/savePrize.htmls" method="post">
        <div class="row">
            <div class="col-md-2">
                <label>设置奖项:</label>
            </div>
            <div class="col-md-8">
                <c:forEach items="${model['prizes']}" var="prize">
                    <div class="radio">
                        <label>
                            <input type="radio" name="prizeCode" value="${prize.code}">
                                ${prize.name}
                        </label>
                    </div>
                </c:forEach>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10">
                <button type="button" class="btn btn-primary"
                        onclick="window.location.href='<%=request.getContextPath()%>/activity/showFans/${model['activityId']}.htmls'">
                    返回
                </button>
                <button id="clearWhiteList" type="button" class="btn btn-primary">
                    清除奖项
                </button>
                <button type="submit" class="btn btn-primary">保存</button>
            </div>
        </div>
        <input type="hidden" id="activityId" name="activityId" value="${model['activityId']}"/>
        <input type="hidden" id="fansId" name="fansId" value="${model['fans'].id}"/>
        <input type="hidden" name="fansNick" value="${model['fans'].nick}"/>
        <input type="hidden" name="id" value=""/>
    </form>
</div>
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        var whiteList = eval(${model['whiteList']});
        if (null != whiteList && "" != whiteList) {
            $("input[name='id']").val(whiteList.id);
            var prizeCode = whiteList.prizeCode;
            $("input[name='prizeCode'][value='" + prizeCode + "']").attr("checked", "checked");
        }

        $("#clearWhiteList").click(function () {
            var activityId = $("#activityId").val();
            var fansId = $("#fansId").val();
            $.ajax({
                url: '<%=request.getContextPath()%>/activity/clearWhiteList.htmls',
                type: 'POST',
                data: {
                    "activityId": activityId,
                    "fansId": fansId
                },
                dataType: "json",
                success: function (data) {
                    if (data.success) {
                        $.globalMessenger().post({
                            message: "清除奖项成功",
                            hideAfter: 2
                        });
                    } else {
                        $.globalMessenger().post({
                            errorMessage: "清除奖项失败",
                            hideAfter: 2
                        });
                    }
                },
                error: function () {
                    $.globalMessenger().post({
                        errorMessage: "清除奖项失败",
                        hideAfter: 2
                    });
                }
            });
        });
    });
</script>
</body>
</html>
