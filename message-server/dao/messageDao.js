/**
 * Created by hanfei on 16/3/28.
 */
var mysql = require('mysql');
var async = require('async');
var $conf = require('../conf/db');
//var $util = require('../util/util');
var $sql = require('./messageSqlMapping');
//console.log($conf.mysql);
var pool = mysql.createPool($conf.mysql);
//console.log(pool);
var jsonWrite = function (res, ret) {
    if (typeof ret === 'undefined') {
        res.json({
            code: '1',
            msg: '操作失败'
        });
    } else {
        res.json(ret);
    }
};


module.exports = {
    queryAllMessage: function (req, res, next) {
        pool.getConnection(function (err, connection) {
            // 获取前台页面传过来的参数
            var param = req.query || req.params;

            // 建立连接，查询数据
            connection.query($sql.queryAll, [], function (err, result) {

                // 以json形式，把操作结果返回给前台页面
                jsonWrite(res, result);

                // 释放连接
                connection.release();
            });
        });
    },
    saveMessage: function (nick, comment, userId, activityId) {
        pool.getConnection(function (err, connection) {

            var fansId = null;
            var tasks = [function (callback) {
                // 开启事务
                connection.beginTransaction(function (err) {
                    callback(err);
                });
            }, function (callback) {
                connection.query('select id from t_usercenter_fans where nick=?', nick, function (err, result) {
                    fansId = result[0].id;
                    callback(err);
                });
            }, function (callback) {
                // 插入log
                var params = [fansId, comment, userId, activityId];
                connection.query('insert into t_usercenter_fans_message(fans_id,content,create_datetime,user_id,activity_id) values(?,?,now(),?,?)', params, function (err, result) {
                    callback(err);
                });
            }, function (callback) {
                // 提交事务
                connection.commit(function (err) {
                    callback(err);
                });
            }];

            async.series(tasks, function (err, results) {
                if (err) {
                    console.log(err);
                    connection.rollback(); // 发生错误事务回滚
                }
                connection.release();
            });
        });

    }
};