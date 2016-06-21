<%@ page import="java.net.URLDecoder" %>
<%--
  Created by IntelliJ IDEA.
  User: hanfei
  Date: 16/5/11
  Time: 下午3:07
  To change this template use File | Settings | File Templates.
--%>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%
    String result = request.getParameter("result");
    String msg = URLDecoder.decode(request.getParameter("msg"), "UTF-8");
%>
<html>
<head>
    <title>会签后台管理系统-签到结果</title>
    <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link href="<%=request.getContextPath()%>/static/css/register.css" rel="stylesheet">
</head>
<body>
<header>
    <div class="register-header">
    </div>
</header>
<div class="container register-content">
    <div class="row">
        <div class="col-md-6">
            <div id="msg"></div>
            <div>5秒钟后跳转登录页面...</div>
        </div>
    </div>
</div>
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        var result = '<%=result%>';
        var msg = '<%=msg%>';
        $("#msg").html(msg);
        setTimeout(function () {
            window.location.href = "<%=request.getContextPath()%>/login.jsp";
        }, 5000);
    });
</script>
</body>
</html>
