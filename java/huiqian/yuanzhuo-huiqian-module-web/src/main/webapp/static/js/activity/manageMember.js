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

    $("#manageMember").addClass("active");
    $("#manageActivity").removeClass("active");
});

function verifyMember(memberId) {
    window.location.href = HuiqianUtil.getWebRootPath() + "/admin/member/verify/" + memberId + ".htmls";
}

function pageselectCallback(page_index, jq) {
    var pageIndex = parseInt(page_index) + 1;
    $.ajax({
            url: HuiqianUtil.getWebRootPath() + '/admin/member/all.htmls',
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
                        $.each(result.data, function (i, member) {
                                content += "<tr>";
//                                        content += "<td>" + activity.id + "</td>";
                                content += "<td>" + member.userName + "</td>";
                                content += "<td>" + member.password + "</td>";
                                content += "<td>" + member.company + "</td>";
                                content += "<td>" + member.phone + "</td>";
                                content += "<td>" + getFormatDateByLong(new Date(member.createTime), 'yyyy-MM-dd hh:mm:ss') + "</td>";
                                content += "<td>" + member.status + "</td>";
                                content += "<td>";
                                content += "<button class='btn btn-default' onclick='javascript:verifyMember(" + member.id + ")'>";
                                content += "审核通过";
                                content += "</button>&nbsp;&nbsp;";
                                content += "</td>";
                                content += "</tr>";
                            }
                        );
                    } else {
                        content += "<tr><td colspan='6' style='text-align: center;'>当前不存在会员数据.</td></tr>";
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