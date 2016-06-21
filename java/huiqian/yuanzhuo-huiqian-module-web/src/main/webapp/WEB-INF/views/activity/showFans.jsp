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
    <title>会签-活动成员管理-查看成员</title>
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
            <button class="btn btn-primary" data-toggle="modal" data-target="#fansModal">添加粉丝</button>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <label>粉丝昵称:</label>
            <input id="nick" type="text" placeholder="粉丝昵称">
            <button id="btnQuery" class="btn btn-primary">查询</button>
        </div>
    </div>
</div>
<table class="table table-bordered table-hover">
    <caption>活动${model['activityId']}的粉丝</caption>
    <thead>
    <tr>
        <th>粉丝昵称</th>
        <th>粉丝名称</th>
        <th>粉丝手机号</th>
        <th>奖项</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody id="Searchresult">
    </tbody>
    <%--<tbody>--%>
    <%--<c:forEach items="${model['fansList']}" var="fans">--%>
    <%--<tr>--%>
    <%--<td>${fans.nick}</td>--%>
    <%--<td>${fans.name}</td>--%>
    <%--<td>${fans.phone}</td>--%>
    <%--<td>--%>
    <%--<button class='btn btn-default'>加入黑名单</button>--%>
    <%--</td>--%>
    <%--</tr>--%>
    <%--</c:forEach>--%>
    <%--</tbody>--%>
</table>
<div id="Pagination" class="pagination"></div>
<div class="modal fade" id="fansModal" tabindex="-1" role="dialog" aria-labelledby="fansModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="fansModalLabel">添加粉丝</h4>
            </div>
            <form id="fansForm" action="<%=request.getContextPath()%>/fans/save.htmls" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nick" class="control-label">粉丝名称:</label>
                        <input type="text" class="form-control" name="nick">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary">保存</button>
                </div>
                <input type="hidden" id="activityId" name="activityId" value="${model['activityId']}">
                <input type="hidden" id="userId" name="userId" value="${sessionScope.user.id}">
            </form>
        </div>
    </div>
</div>
<input type="hidden" id="total" name="total" value="${model['total']}">
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="<%=request.getContextPath()%>/static/js/activity/showFans.js"></script>
</body>
</html>
