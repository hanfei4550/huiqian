<%--
  Created by IntelliJ IDEA.
  User: hanfei
  Date: 16/5/16
  Time: 下午3:17
  To change this template use File | Settings | File Templates.
--%>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<html>
<head>
    <title>会签-活动成员管理-查看详情</title>
    <link href="<%=request.getContextPath()%>/static/css/activity/showDetail.css" rel="stylesheet"/>
</head>
<body>
<div class="container">
    <form id="activityForm" action="<%=request.getContextPath()%>/activity/update.htmls" method="post">
        <div class="row">
            <div class="col-md-2">
                <label for="name" class="control-label">活动名称:</label>
            </div>
            <div class="col-md-8">
                <input type="text" class="form-control" id="name" name="name" value="${model['activity'].name}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <label for="subject" class="control-label">活动主题:</label>
            </div>
            <div class="col-md-8">
                <input type="text" class="form-control" id="subject" name="subject"
                       value="${model['activity'].subject}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <label for="scale" class="control-label">活动规模:</label>
            </div>
            <div class="col-md-8">
                <input type="text" class="form-control" id="scale" name="scale" value="${model['activity'].scale}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <label for="beginTime" class="control-label">开始时间:</label>
            </div>
            <div class="col-md-8">
                <input type="text" class="form-control" id="beginTime" name="beginTime"
                       value="<fmt:formatDate value="${model['activity'].beginTime}" pattern="yyyy-MM-dd HH:mm:ss"/>"
                       readonly>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <label for="endTime" class="control-label">结束时间:</label>
            </div>
            <div class="col-md-8">
                <input type="text" class="form-control readonly" id="endTime" name="endTime"
                       value="<fmt:formatDate value="${model['activity'].endTime}" pattern="yyyy-MM-dd HH:mm:ss"/>"
                       readonly>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <label for="industry" class="control-label">行业:</label>
            </div>
            <div class="col-md-8">
                <input type="text" class="form-control" id="industry" name="industry"
                       value="${model['activity'].industry}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <label class="control-label">是否验证用户:</label>
            </div>
            <div class="col-md-8">
                <input type="checkbox" name="isValidateUser" value="1">验证用户
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <label class="control-label">活动功能:</label>
            </div>
            <div class="col-md-8">
                <input type="checkbox" name="functions" value="1">一键签到
                <input type="checkbox" name="functions" value="2">定制3D
                <input type="checkbox" name="functions" value="3">多屏弹幕
                <input type="checkbox" name="functions" value="4">3D抽奖
                <input type="checkbox" name="functions" value="5">数据分析
            </div>
        </div>
        <div class="row">
            <div class="col-md-10">
                <c:if test="${sessionScope.user.status == 2}">
                    <button type="button" class="btn btn-primary"
                            onclick="window.location.href='<%=request.getContextPath()%>/admin/activity/total.htmls?memberId=${sessionScope.user.id}'">
                        返回
                    </button>
                </c:if>
                <c:if test="${sessionScope.user.status == 1}">
                    <button type="button" class="btn btn-primary"
                            onclick="window.location.href='<%=request.getContextPath()%>/activity/all.htmls?memberId=${sessionScope.user.id}'">
                        返回
                    </button>
                </c:if>
                <button type="submit" class="btn btn-primary" disabled>提交活动</button>
            </div>
        </div>
    </form>
</div>
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        var isValidateUser = "${model['activity'].isValidateUser}";
        if (isValidateUser == "1") {
            $("input[name='isValidateUser']").attr("checked", "checked");
        }
        var functions = "${model['activity'].functions}";
        if (functions != "") {
            var functionArr = functions.split(",");
            for (var i = 0; i < functionArr.length; i++) {
                $("input[name='functions'][value='" + functionArr[i] + "']").attr("checked", "checked");
            }
        }
    });
</script>
</body>
</html>
