/**
 * Created by hanfei on 16/5/13.
 */

function getActivityWinningList() {
    var activityId = $("#activityId").val();
    $.ajax({
            url: HuiqianUtil.getWebRootPath() + '/activity/getActivityWinningList/' + activityId + '.htmls',
            method: 'get',
            dataType: 'json',
            success: function (result) {
                if (result.success) {
                    $("#Searchresult").empty();
                    var content = "";
                    if (result.data.length > 0) {
                        $.each(result.data, function (i, winninglist) {
                                content += "<tr>";
                                content += "<td>" + winninglist.nick + "</td>";
                                content += "<td>" + winninglist.prizeCode + "</td>";
                                content += "<td>" + winninglist.prizeName + "</td>";
                                content += "</tr>";
                            }
                        );
                    }
                    else {
                        content += "<tr><td colspan='6' style='text-align: center;'>当前不存在中奖名单数据.</td></tr>";
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
    getActivityWinningList();
});