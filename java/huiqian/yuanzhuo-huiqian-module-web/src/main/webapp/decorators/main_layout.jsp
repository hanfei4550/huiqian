<%@ page language="java" contentType="text/html; charset=UTF-8"
         pageEncoding="UTF-8" %>
<%@ taglib prefix="decorator" uri="http://www.opensymphony.com/sitemesh/decorator" %>
<%@ taglib prefix="page" uri="http://www.opensymphony.com/sitemesh/page" %>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title><decorator:title default="会签后台管理系统"/></title>
    <!-- Bootstrap core CSS -->
    <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link href="<%=request.getContextPath()%>/static/css/messenger.css" rel="stylesheet">
    <link href="<%=request.getContextPath()%>/static/css/messenger-theme-future.css" rel="stylesheet">
    <link href="<%=request.getContextPath()%>/static/css/pagination.css" rel="stylesheet">
    <link href="<%=request.getContextPath()%>/static/css/main-layout.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <decorator:head/>
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">会签后台管理系统</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">欢迎您!&nbsp;&nbsp;${sessionScope.user.userName}</a></li>
                <li><a href="<%=request.getContextPath()%>/member/logout.htmls">退出</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <c:if test="${sessionScope.user.status == 2}">
                    <li class="active" id="manageActivity">
                        <a href="<%=request.getContextPath()%>/admin/activity/total.htmls?memberId=${sessionScope.user.id}">活动管理</a>
                    </li>
                    <li id="manageMember">
                        <a href="<%=request.getContextPath()%>/admin/member/total.htmls?memberId=${sessionScope.user.id}">用户管理</a>
                    </li>
                </c:if>
                <c:if test="${sessionScope.user.status == 1}">
                    <li class="active"><a
                            href="<%=request.getContextPath()%>/activity/all.htmls?memberId=${sessionScope.user.id}">活动管理</a>
                    </li>
                </c:if>
            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <decorator:body/>
        </div>
    </div>
</div>


<div style="display:none;">
    <input id="userId" value="${sessionScope.user.id}"/>
    <input id="userName" value="${sessionScope.user.userName}"/>
</div>

<hr>

<footer>
    <p style="text-align: center;">&copy; Company 2016</p>
</footer>

<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="<%=request.getContextPath()%>/static/js/messenger.js"></script>
<script src="<%=request.getContextPath()%>/static/js/jquery.pagination.js"></script>
<script src="<%=request.getContextPath()%>/static/js/huiqian.common.js"></script>
<script>
    $._messengerDefaults = {
        extraClasses: 'messenger-fixed messenger-theme-future messenger-on-top'
    }
</script>
</body>
</html>