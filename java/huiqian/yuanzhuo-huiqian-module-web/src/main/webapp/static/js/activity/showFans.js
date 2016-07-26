/**
 * Created by hanfei on 16/5/13.
 */
var pageSize = 5;

function pageselectCallback(page_index, jq) {
    var activityId = $("#activityId").val();
    var nick = $("#nick").val();
    var pageIndex = parseInt(page_index) + 1;
    $.ajax({
            url: HuiqianUtil.getWebRootPath() + '/fans/page.htmls',
            method: 'get',
            data: {
                "activityId": activityId,
                "pageIndex": pageIndex,
                "nick": encodeURIComponent(nick)
            },
            dataType: 'json',
            success: function (result) {
                if (result.success) {
                    $("#Searchresult").empty();
                    var content = "";
                    $("#totalNum").html(result.data.total);
                    if (result.data.data.length > 0) {
                        $.each(result.data.data, function (i, fans) {
                                var company = fans.company;
                                if (company == null) {
                                    company = "";
                                }
                                content += "<tr>";
                                content += "<td>" + fans.nick + "</td>";
                                content += "<td>" + fans.name + "</td>";
                                content += "<td>" + fans.phone + "</td>";
                                content += "<td>" + company + "</td>";
                                content += "<td>" + fans.prize + "</td>";
                                content += "<td>";
                                content += "<button class='btn btn-default disabled'>";
                                content += "加入黑名单";
                                content += "</button>&nbsp;&nbsp;";
                                content += "<button class='btn btn-default' onclick='window.location.href = \"" + HuiqianUtil.getWebRootPath() + "/activity/setPrize/" + activityId + "/" + fans.id + ".htmls\"'>";
                                content += "设置奖项";
                                content += "</button>&nbsp;&nbsp;";
                                content += "<button class='btn btn-default' onclick='window.location.href = \"" + HuiqianUtil.getWebRootPath() + "/fans/delete/" + activityId + "/" + fans.id + ".htmls\"'>";
                                content += "删除";
                                content += "</button>";
                                content += "</td>";
                                content += "</tr>";
                            }
                        );
                    }
                    else {
                        content += "<tr><td colspan='6' style='text-align: center;'>当前不存在成员数据.</td></tr>";
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
    $("#btnQuery").click(function () {
        pageselectCallback(0);
    });
});