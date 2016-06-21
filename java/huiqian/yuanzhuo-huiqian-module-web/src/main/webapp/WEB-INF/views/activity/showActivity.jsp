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
    <%--<link href="<%=request.getContextPath()%>/static/css/pagination.css" rel="stylesheet">--%>
    <link href="<%=request.getContextPath()%>/static/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <%--<link href="<%=request.getContextPath()%>/static/css/bootstrapValidator.min.css" rel="stylesheet"/>--%>
    <meta charset="UTF-8">
    <title>会签-活动管理</title>
</head>
<body>
<div id="operation">
    <button class="btn btn-primary" id="btn_add_activity" data-toggle="modal" data-target="#exampleModal">添加活动</button>
</div>
<table class="table table-bordered table-hover">
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">添加活动</h4>
            </div>
            <form id="activityForm" action="<%=request.getContextPath()%>/activity/save.htmls" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="control-label">活动名称:</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="subject" class="control-label">活动主题:</label>
                        <input type="text" class="form-control" id="subject" name="subject">
                    </div>
                    <div class="form-group">
                        <label for="scale" class="control-label">活动规模:</label>
                        <input type="text" class="form-control" id="scale" name="scale">
                    </div>
                    <div class="form-group">
                        <label for="beginTime" class="control-label">开始时间:</label>

                        <div class="input-group date form_datetime col-md-6" data-date="1979-09-16 05:25:20"
                             data-date-format="yyyy-mm-dd hh:ii:ss" data-link-field="beginTime">
                            <input class="form-control" size="16" type="text" value="" readonly>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                        </div>
                        <input type="hidden" value="" id="beginTime" name="beginTime"/><br/>

                        <label for="endTime" class="control-label">结束时间:</label>

                        <div class="input-group date form_datetime col-md-6" data-date="1979-09-16 05:25:20"
                             data-date-format="yyyy-mm-dd hh:ii:ss" data-link-field="endTime">
                            <input class="form-control" size="16" type="text" value="" readonly>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                        </div>
                        <input type="hidden" value="" id="endTime" name="endTime"/><br/>
                    </div>
                    <div class="form-group">
                        <label for="industry" class="control-label">行业:</label>
                        <input type="text" class="form-control" id="industry" name="industry">
                    </div>
                    <div class="form-group">
                        <label class="control-label">是否验证用户:</label>
                        <input type="checkbox" name="isValidateUser" value="1">验证用户
                    </div>
                    <div class="form-group">
                        <label class="control-label">活动功能:</label>
                        <input type="checkbox" name="functions" value="1">一键签到
                        <input type="checkbox" name="functions" value="2">定制3D
                        <input type="checkbox" name="functions" value="3">多屏弹幕
                        <input type="checkbox" name="functions" value="4">3D抽奖
                        <input type="checkbox" name="functions" value="5">数据分析
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary">提交活动</button>
                </div>
                <input type="hidden" id="memberId" name="memberId" value="${model['memberId']}">
                <input type="hidden" id="total" name="total" value="${model['total']}">
            </form>
        </div>
    </div>
</div>
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<%--<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>--%>
<%--<script src="<%=request.getContextPath()%>/static/js/jquery.pagination.js"></script>--%>
<script src="<%=request.getContextPath()%>/static/js/bootstrap-datetimepicker.js"></script>
<%--<script src="<%=request.getContextPath()%>/static/js/bootstrap-datetimepicker.zh-CN.js"></script>--%>
<script src="<%=request.getContextPath()%>/static/js/bootstrapValidator.min.js"></script>
<script src="<%=request.getContextPath()%>/static/js/activity/showActivity.js"></script>
</body>
</html>