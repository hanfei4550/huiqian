<%--
  Created by IntelliJ IDEA.
  User: hanfei
  Date: 16/5/13
  Time: 上午11:18
  To change this template use File | Settings | File Templates.
--%>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<html>
<head>
    <title>会签-活动管理-中奖名单</title>
</head>
<body>
<div>
    <div class="row">
        <div class="col-md-12">
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
        </div>
    </div>
</div>
<table class="table table-bordered table-hover">
    <caption>活动${model['activityId']}的粉丝</caption>
    <thead>
    <tr>
        <th>粉丝昵称</th>
        <th>奖项编码</th>
        <th>奖项名称</th>
    </tr>
    </thead>
    <tbody id="Searchresult">
    </tbody>
</table>
<div id="Pagination" class="pagination"></div>
<input type="hidden" id="activityId" name="activityId" value="${model['activityId']}">
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="<%=request.getContextPath()%>/static/js/activity/showWinningList.js?t=20160530"></script>
</body>
</html>
