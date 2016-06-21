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
    $("#manageActivity").addClass("active");
    $("#manageMember").removeClass("active");
});

function pageselectCallback(page_index, jq) {
    var pageIndex = parseInt(page_index) + 1;
    $.ajax({
            url: HuiqianUtil.getWebRootPath() + '/admin/activity/all.htmls',
            method: 'get',
            data: {
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
                                content += "<button disabled class='btn btn-default' onclick='window.location.href = \"" + HuiqianUtil.getWebRootPath() + "/activity/showUpload/" + activity.id + ".htmls\"'>";
                                content += "添加成员";
                                content += "</button>&nbsp;&nbsp;";
                                content += "<button class='btn btn-default' onclick='window.location.href = \"" + HuiqianUtil.getWebRootPath() + "/activity/showFans/" + activity.id + ".htmls\"'>";
                                content += "查看成员";
                                content += "</button>&nbsp;&nbsp;";
                                content += "<button class='btn btn-default' onclick='window.location.href = \"" + HuiqianUtil.getWebRootPath() + "/activity/generateQrcode/" + activity.activityNo + ".htmls\"'>";
                                content += "二维码";
                                content += "</button>";
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