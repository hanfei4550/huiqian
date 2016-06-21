<%--
  Created by IntelliJ IDEA.
  User: hanfei
  Date: 16/5/14
  Time: 上午10:25
  To change this template use File | Settings | File Templates.
--%>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<html>
<head>
    <meta charset="UTF-8">
    <title>会签-生成二维码</title>
</head>
<body>
<div class="container">
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
        </div>
    </div>
    <h2>生成活动二维码</h2>

    <div class="row">
        <div class="col-md-10">
            <textarea class="form-control" rows="6" id="urlContent">${model['url']}</textarea>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-10" id="qrcode"></div>
    </div>
</div>
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="<%=request.getContextPath()%>/static/js/jquery.qrcode.js"></script>
<script type="text/javascript" src="<%=request.getContextPath()%>/static/js/qrcode.js"></script>
<script>
    jQuery('#qrcode').qrcode({
        width: 200,
        height: 200,
        correctLevel: QRErrorCorrectLevel.H,
        text: $("#urlContent").val()
    });
</script>
</body>
</html>