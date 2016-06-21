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
    <title>会签-用户管理</title>
</head>
<body>
<table class="table table-bordered table-hover">
    <caption>用户列表</caption>
    <thead>
    <tr>
        <th>用户名称</th>
        <th>用户密码</th>
        <th>用户公司</th>
        <th>联系人手机</th>
        <th>创建时间</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody id="Searchresult">
    </tbody>
</table>
<div id="Pagination" class="pagination"></div>
<input type="hidden" id="total" name="total" value="${model['total']}">
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="<%=request.getContextPath()%>/static/js/activity/manageMember.js"></script>
</body>
</html>