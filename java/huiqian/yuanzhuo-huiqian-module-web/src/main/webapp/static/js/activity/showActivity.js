/**
 * Created by hanfei on 16/5/14.
 */
var pageSize = 5;

$(document).ready(function () {
    //此demo通过Ajax加载分页元素
    var num_entries = $("#total").val();
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
                    callback: function (value, validator) {
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
                    callback: function (value, validator) {
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
            url: HuiqianUtil.getWebRootPath() + '/member/query.htmls',
            method: 'get',
            data: {
                "memberId": memberId,
                "pageIndex": pageIndex
            },
            dataType: 'json',
            success: function (result) {
                if (result.success) {
                    $("#Searchresult").empty();
                    var content = "";
                    if (result.data.length > 0) {
                        $.each(result.data, function (i, activity) {
                                content += "<tr>";
//                                        content += "<td>" + activity.id + "</td>";
                                content += "<td>" + activity.name + "</td>";
                                content += "<td>" + activity.subject + "</td>";
//                                        content += "<td>" + activity.industry + "</td>";
                                content += "<td>" + getFormatDateByLong(new Date(activity.beginTime), 'yyyy-MM-dd hh:mm:ss') + "</td>";
                                content += "<td>" + getFormatDateByLong(new Date(activity.endTime), 'yyyy-MM-dd hh:mm:ss') + "</td>";
                                content += "<td>" + activity.activityNo + "</td>";
                                content += "<td>";
                                content += "<button class='btn btn-default' onclick='window.location.href = \"" + HuiqianUtil.getWebRootPath() + "/activity/showDetail/" + activity.id + ".htmls\"'>";
                                content += "查看详情";
                                content += "</button>&nbsp;&nbsp;";
                                content += "<button class='btn btn-default' onclick='window.location.href = \"" + HuiqianUtil.getWebRootPath() + "/activity/showUpload/" + activity.id + ".htmls\"'>";
                                content += "添加成员";
                                content += "</button>&nbsp;&nbsp;";
                                content += "<button class='btn btn-default' onclick='window.location.href = \"" + HuiqianUtil.getWebRootPath() + "/activity/showFans/" + activity.id + ".htmls\"'>";
                                content += "查看成员";
                                content += "</button>&nbsp;&nbsp;";
                                content += "<button class='btn btn-default' onclick='window.location.href = \"" + HuiqianUtil.getWebRootPath() + "/activity/generateQrcode/" + activity.activityNo + ".htmls\"'>";
                                content += "二维码";
                                content += "</button>&nbsp;&nbsp;";
                                content += "<button class='btn btn-default' onclick='window.location.href = \"" + HuiqianUtil.getWebRootPath() + "/activity/showWinningList/" + activity.id + ".htmls\"'>";
                                content += "中奖名单";
                                content += "</button>&nbsp;&nbsp;";
                                content += "<button class='btn btn-default' onclick='window.location.href = \"" + HuiqianUtil.getWebRootPath() + "/prize/showPrize/" + activity.id + ".htmls\"'>";
                                content += "设置奖项";
                                content += "</button>&nbsp;&nbsp;";
                                content += "<button class='btn btn-default' onclick='window.location.href = \"" + HuiqianUtil.getWebRootPath() + "/activity/delete/" + memberId + "/" + activity.id + ".htmls\"'>";
                                content += "删除活动";
                                content += "</button>&nbsp;&nbsp;";
                                content += "</td>";
                                content += "</tr>";
                            }
                        );
                    } else {
                        content += "<tr><td colspan='6' style='text-align: center;'>当前不存在活动数据.</td></tr>";
                    }
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