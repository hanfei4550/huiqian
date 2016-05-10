/**
 * Created by caizhengda on 2015/9/14 0002.
 */

var moduleList;
$(function () {
    moduleList = new ModuleList();
});

/**
 * 模版编辑器
 * @constructor
 */
var ModuleList = function () {
    var that = this;
    that.init();
};

function isNotNull(value) {
    if (null != value && 'null' != value && '' != value && undefined != value && 'undefined' != value) {
        return true;
    }
    return false;
}

ModuleList.prototype = {
    $showDataTableEl: $('.show-data-table'),
    pageParams: {
        pageNo: 0,
        pageSize: 10
    },
    init: function () {
        var that = this;

        //tip提示
        $('[data-toggle="tooltip"]').tooltip();

        $("#viewBlacklist").click(function () {
            that.queryBlackList();
        });

        $("#viewFanslist").click(function () {
            that.query(that.buildPageParams(), function (response) {
            });
        });

        //查询
        $('#searchForm').submit(function () {
            that.pageParams.pageNo = 0;
            that.query(that.buildPageParams(), function (response) {

            });
            return false;
        });
        $('#searchForm').trigger("submit");
        return that;
    },
    query: function (params, callback) {//分页查询
        var that = this;
        YTDialog.loading('努力查询中。。。', false);
        $.ajax({
            url: 'AdminController.php',
            data: params,
            type: 'get',
            dataType: 'json',
            success: function (data) {
                var $page = $("#pagiation");
                that.$showDataTableEl.find('tbody').empty();
                if (data) {
                    //$page.bs_pagination({
                    //    currentPage: params.pageNo,                // 当前页
                    //    rowsPerPage: params.pageSize,                      // 每页显示的条数
                    //    sizeList: [10, 20, 50],
                    //    totalRows: data.result.totalElements,               // 总条数
                    //    totalPages: data.result.totalPages,                 // 总页数
                    //    onChangePage: function (event, data) {
                    //        that.pageParams.pageNo = data.currentPage;             // 返回当前页
                    //        that.pageParams.pageSize = data.rowsPerPage;                // 返回每页的显示的条数
                    //        that.query(that.buildPageParams());
                    //    }
                    //});
                    var renderHtml = that.generateListHtml(data);
                    $('tbody', that.$showDataTableEl).html(renderHtml);
                    $page.show();
                } else {
                    $page.hide();
                }
                callback && callback(data);
            },
            error: function (data) {
                YTMsg.error(data.responseText);
            },
            complete: function () {
                YTDialog.close();
            }
        });
    },
    queryBlackList: function () {
        var that = this;
        YTDialog.loading('努力查询中。。。', false);
        $.ajax({
            url: 'QueryBlacklistController.php',
            data: {
                "userId": $("#userId").val(),
                "activityId": $("#activityId").val()
            },
            type: 'get',
            dataType: 'json',
            success: function (data) {
                var $page = $("#pagiation");
                that.$showDataTableEl.find('tbody').empty();
                if (data) {
                    var renderHtml = that.generateListHtml(data, true);
                    $('tbody', that.$showDataTableEl).html(renderHtml);
                    $page.show();
                } else {
                    $page.hide();
                }
            },
            error: function (data) {
                YTMsg.error(data.responseText);
            },
            complete: function () {
                YTDialog.close();
            }
        });
    },
    buildPageParams: function () {
        var that = this;
        var condition = {};
        var nick = $.trim($("#nick").val());
        if (isNotNull(nick)) {
            condition.nick = nick;
        }
        var name = $.trim($("#name").val());
        if (isNotNull(name)) {
            condition.name = name;
        }
        var userId = $.trim($("#userId").val());
        var activityId = $.trim($("#activityId").val());
        return $.extend({"userId": userId, "activityId": activityId}, that.pageParams, {
            condition: encodeURIComponent(JSON.stringify(condition))
        });
    },
    addBlacklist: function (id, nick, name) {
        var that = this;
        $.ajax({
            url: 'AddBlacklistController.php',
            data: {
                "fansId": id,
                "name": encodeURIComponent(name),
                "nick": encodeURIComponent(nick),
                "userId": $("#userId").val(),
                "activityId": $("#activityId").val()
            },
            type: 'get',
            success: function (data) {
                YTMsg.info("添加黑名单成功!");
                that.query(that.buildPageParams(), function (response) {
                });
            },
            error: function (data) {
                YTMsg.error(data.responseText);
            },
            complete: function () {
                YTDialog.close();
            }
        });
    },
    removeBlacklist: function (id) {
        var that = this;
        $.ajax({
            url: 'RemoveBlacklistController.php',
            data: {
                "id": id
            },
            type: 'get',
            success: function (data) {
                YTMsg.info("移除黑名单成功!");
                that.query(that.buildPageParams(), function (response) {

                });
            },
            error: function (data) {
                YTMsg.error(data.responseText);
            },
            complete: function () {
                YTDialog.close();
            }
        });
    },
    generateListHtml: function (moduleItems, isBlacklist) {
        var getTr = function (item) {
            var tr = "<tr>" +
                "<td>" + item.id + "</td>" +
                "<td>" + (item.nick) + "</td>" +
                "<td>" + (item.name) + "</td>";
            if (isBlacklist) {
                tr = tr + "<td>" +
                    "<a href=\"javascript:moduleList.removeBlacklist(" + item.id + ");\" target='_blank' type='button' class='btn btn-default btn-edit' title='移除黑名单'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a>" +
                    "</td>" + "</tr>";
            } else {
                tr = tr + "<td>" +
                    "<a href=\"javascript:moduleList.addBlacklist(" + item.id + ",'" + item.nick + "','" + item.name + "');\" target='_blank' type='button' class='btn btn-default btn-edit' title='加入黑名单'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a>" +
                    "</td>" + "</tr>";
            }
            return $(tr).data("item", item);
        };
        var $trList = $(moduleItems).map(function (index, moduleItem) {
            var $tr = getTr(moduleItem);
            return $tr;
        }).get();
        return $trList;
    }
};

Date.prototype.Format = function (fmt) { //author: meizz
    var o = {
        "M+": this.getMonth() + 1,                 //月份
        "d+": this.getDate(),                    //日
        "h+": this.getHours(),                   //小时
        "m+": this.getMinutes(),                 //分
        "s+": this.getSeconds(),                 //秒
        "q+": Math.floor((this.getMonth() + 3) / 3), //季度
        "S": this.getMilliseconds()             //毫秒
    };
    if (/(y+)/.test(fmt))
        fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
        if (new RegExp("(" + k + ")").test(fmt))
            fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
}
