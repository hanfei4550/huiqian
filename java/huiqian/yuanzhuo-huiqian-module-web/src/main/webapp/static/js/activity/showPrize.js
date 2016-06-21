/**
 * Created by hanfei on 16/5/13.
 */

function getPrizeList() {
    var activityId = $("#activityId").val();
    $.ajax({
            url: HuiqianUtil.getWebRootPath() + '/prize/list/' + activityId + '.htmls',
            method: 'get',
            dataType: 'json',
            success: function (result) {
                if (result.success) {
                    $("#Searchresult").empty();
                    var content = "";
                    if (result.data.length > 0) {
                        $.each(result.data, function (i, prize) {
                                content += "<tr>";
                                content += "<td>" + prize.code + "</td>";
                                content += "<td>" + prize.name + "</td>";
                                content += "<td>" + prize.prizeName + "</td>";
                                content += "<td>";
                                content += "<button class='btn btn-default' onclick='window.location.href = \"" + HuiqianUtil.getWebRootPath() + "/prize/delete/" + activityId + "/" + prize.id + ".htmls\"'>";
                                content += "删除";
                                content += "</button>&nbsp;&nbsp;";
                                content += "</td>";
                                content += "</tr>";
                            }
                        );
                    }
                    else {
                        content += "<tr><td colspan='6' style='text-align: center;'>当前不存在奖项数据.</td></tr>";
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
    getPrizeList();
});