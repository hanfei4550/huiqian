<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <link href="${rc.contextPath}/static/css/pagination.css" rel="stylesheet">
    <link href="${rc.contextPath}/static/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="${rc.contextPath}/static/css/bootstrapValidator.min.css" rel="stylesheet"/>
    <meta charset="UTF-8">
    <title>圆桌骑士-活动列表</title>
</head>
<body>
<div id="operation">
    <button class="btn btn-primary" id="btn_add_activity" data-toggle="modal" data-target="#exampleModal">添加活动</button>
</div>
<table class="table table-bordered table-hover">
    <thead>
    <tr>
    <#--<th>活动ID</th>-->
        <th>活动名称</th>
        <th>活动主题</th>
    <#--<th>行业</th>-->
        <th>开始时间</th>
        <th>结束时间</th>
        <th>活动编号</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody id="Searchresult">
    </tbody>
</table>
<div id="Pagination" class="pagination"><!-- 这里显示分页 --></div>
<#--<div id="hiddenresult" style="display: none;">-->
<#--<#list model["activities"] as activity>-->
<#--<tr>-->
<#--<td>${activity.id}</td>-->
<#--<td>${activity.name}</td>-->
<#--<td>${activity.subject}</td>-->
<#--<td>${activity.industry}</td>-->
<#--<td>${activity.beginTime?string("yyyy-MM-dd HH:mm:ss")}</td>-->
<#--<td>${activity.endTime?string("yyyy-MM-dd HH:mm:ss")}</td>-->
<#--<td>-->
<#--<button class="btn btn-default"-->
<#--onclick="window.location.href='${rc.contextPath}/activity/showUpload/${activity.id}.htmls'">-->
<#--添加活动成员-->
<#--</button>-->
<#--</td>-->
<#--</tr>-->
<#--</#list>-->
<#--</div>-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">添加活动</h4>
            </div>
            <form id="activityForm" action="${rc.contextPath}/activity/save.htmls" method="post">
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

                        <div class="input-group date form_datetime col-md-5" data-date="1979-09-16 05:25:20"
                             data-date-format="yyyy-mm-dd hh:ii:ss" data-link-field="beginTime">
                            <input class="form-control" size="16" type="text" value="" readonly>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                        </div>
                        <input type="hidden" id="beginTime" value="" name="beginTime"/><br/>

                        <label for="endTime" class="control-label">结束时间:</label>

                        <div class="input-group date form_datetime col-md-5" data-date="1979-09-16 05:25:20"
                             data-date-format="yyyy-mm-dd hh:ii:ss" data-link-field="endTime">
                            <input class="form-control" size="16" type="text" value="" readonly>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                        </div>
                        <input type="hidden" id="endTime" value="" name="endTime"/><br/>
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
                <input type="hidden" name="memberId" value="${model['memberId']}">
            </form>
        </div>
    </div>
</div>
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<#--<script src="//cdn.bootcss.com/jquery.form/3.51/jquery.form.min.js"></script>-->
<script src="${rc.contextPath}/static/js/jquery.pagination.js"></script>
<script src="${rc.contextPath}/static/js/bootstrap-datetimepicker.min.js"></script>
<script src="${rc.contextPath}/static/js/bootstrap-datetimepicker.zh-CN.js"></script>
<script src="${rc.contextPath}/static/js/bootstrapValidator.min.js"></script>
<script>
    var pageSize = 5;

    $(document).ready(function () {
        //此demo通过Ajax加载分页元素
        var num_entries = '${model["total"]}';
        // 创建分页
        $("#Pagination").pagination(num_entries, {
            num_edge_entries: 1, //边缘页数
            num_display_entries: 4, //主体页数
            callback: pageselectCallback,
            items_per_page: pageSize, //每页显示1项
            prev_text: "前一页",
            next_text: "后一页"
        });
    });

    $('#activityForm').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: '活动名称不能为空'
                    },
                    stringLength: {
                        max: 30,
                        message: '活动名称不能超过30个字符'
                    }
                }
            },
            subject: {
                validators: {
                    notEmpty: {
                        message: '活动主题不能为空'
                    },
                    stringLength: {
                        max: 50,
                        message: '活动主题不能超过50个字符'
                    }
                }
            },
            scale: {
                validators: {
                    notEmpty: {
                        message: '活动规模不能为空'
                    }
                }
            },
            beginTime: {
                validators: {
                    notEmpty: {
                        message: '开始时间不能为空'
                    },
                    callback: {
                        message: '开始时间不能大于结束时间',
                        callback: function (value, validator, $field, options) {
                            var end = $('#endTime').val();
                            var beginDate = strToDate(value);
                            var endDate = strToDate(end);
                            return beginDate <= endDate;
                        }
                    }
                }
            },
            endTime: {
                validators: {
                    notEmpty: {
                        message: '结束时间不能为空'
                    },
                    callback: {
                        message: '结束时间不能小于开始时间',
                        callback: function (value, validator, $field, options) {
                            var start = $('#startTime').val();
                            var beginDate = strToDate(start);
                            var endDate = strToDate(value);
                            validator.updateStatus('beginTime', 'VALID');
                            return endDate >= beginDate;
                        }
                    }
                }
            }
        }
    });

    $('.form_datetime').datetimepicker({
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    });

    function pageselectCallback(page_index, jq) {
        var memberId = $("#memberId").val();
        var pageIndex = parseInt(page_index) + 1;
        $.ajax({
                    url: '${rc.contextPath}/member/query.htmls',
                    method: 'post',
                    data: {
                        "memberId": "${model['memberId']}",
                        "pageIndex": pageIndex
                    },
                    dataType: 'json',
                    success: function (result) {
                        if (result.success) {
                            $("#Searchresult").empty();
                            var content = "";
                            $.each(result.data, function (i, activity) {
                                        content += "<tr>";
//                                        content += "<td>" + activity.id + "</td>";
                                        content += "<td>" + activity.name + "</td>";
                                        content += "<td>" + activity.subject + "</td>";
//                                        content += "<td>" + activity.industry + "</td>";
                                        content += "<td>" + activity.beginTime + "</td>";
                                        content += "<td>" + activity.endTime + "</td>";
                                        content += "<td>" + activity.activityNo + "</td>";
                                        content += "<td>";
                                        content += "<button class='btn btn-default' onclick='window.location.href = \"${rc.contextPath}/activity/showDetail/" + activity.id + ".htmls\"'>";
                                        content += "查看详情";
                                        content += "</button>&nbsp;&nbsp;";
                                        content += "<button class='btn btn-default' onclick='window.location.href = \"${rc.contextPath}/activity/showUpload/" + activity.id + ".htmls\"'>";
                                        content += "添加成员";
                                        content += "</button>&nbsp;&nbsp;";
                                        content += "<button class='btn btn-default' onclick='window.location.href = \"${rc.contextPath}/activity/showFans/" + activity.id + ".htmls\"'>";
                                        content += "查看成员";
                                        content += "</button>";
                                        content += "</td>";
                                        content += "</tr>";
                                    }
                            );
                            $("#Searchresult").append(content);
                        }
                    },
                    error: function () {
                        alert("获取数据失败,请稍后重试.");
                    }
                }
        );
    }

    function strToDate(strDate) {
        strDate = strDate.replace(/-/g, "/");
        var date = new Date(strDate);
        return date;
    }
</script>
</body>
</html>