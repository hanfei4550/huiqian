<%--
  Created by IntelliJ IDEA.
  User: hanfei
  Date: 16/5/14
  Time: 上午10:25
  To change this template use File | Settings | File Templates.
--%>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<html>
<head>
    <meta charset="UTF-8">
    <title>会签-活动管理</title>
</head>
<body>
<table class="table table-bordered table-hover">
    <caption>活动列表</caption>
    <thead>
    <tr>
        <th>活动名称</th>
        <th>活动主题</th>
        <th>开始时间</th>
        <th>结束时间</th>
        <th>活动号</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody id="Searchresult">
    </tbody>
</table>
<div id="Pagination" class="pagination"></div>
<input type="hidden" id="total" name="total" value="${model['total']}">
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="<%=request.getContextPath()%>/static/js/activity/manageActivity.js"></script>
</body>
</html>