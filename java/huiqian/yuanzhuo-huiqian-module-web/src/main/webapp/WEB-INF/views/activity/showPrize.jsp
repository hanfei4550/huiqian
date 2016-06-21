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
    <title>会签-活动管理-设置奖项</title>
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
            <button class="btn btn-primary" id="btn_add_prize" data-toggle="modal" data-target="#prizeModal">添加奖项
            </button>
        </div>
    </div>
</div>
<table class="table table-bordered table-hover">
    <caption>活动${model['activityId']}的奖项</caption>
    <thead>
    <tr>
        <th>奖项编码</th>
        <th>奖项名称</th>
        <th>奖品名称</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody id="Searchresult">
    </tbody>
</table>
<div id="Pagination" class="pagination"></div>
<div class="modal fade" id="prizeModal" tabindex="-1" role="dialog" aria-labelledby="prizeModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="prizeModalLabel">添加奖项</h4>
            </div>
            <form id="prizeForm" action="<%=request.getContextPath()%>/prize/save.htmls" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="code" class="control-label">奖项编码:</label>
                        <input type="text" class="form-control" id="code" name="code">
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">奖项名称:</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="prizeName" class="control-label">奖品名称:</label>
                        <input type="text" class="form-control" id="prizeName" name="prizeName">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary">保存</button>
                </div>
                <input type="hidden" id="activityId" name="activityId" value="${model['activityId']}">
            </form>
        </div>
    </div>
</div>
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="<%=request.getContextPath()%>/static/js/activity/showPrize.js?t=20160601"></script>
</body>
</html>
