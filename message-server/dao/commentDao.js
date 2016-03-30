/**
 * Created by hanfei on 16/3/28.
 */
var mysql = require('mysql');

var connection = mysql.createConnection({
    host: '120.26.231.8',
    user: 'root',
    password: 'yzqs1605',
    port: '3306',
    database: 'huiqian',
    insecureAuth: true
});

connection.connect();

var userAddSql = 'insert into  t_usercenter_fans_message(fans_id,content,create_datetime,user_id,activity_id) values(?,?,now(),?,?)';

var userAddSql_Params = ['1050', '测试', 1, 1];

connection.query(userAddSql, userAddSql_Params, function (err, result) {
    if (err) {
        console.log('[INSERT ERROR] - ', err.message);
        return;
    }
    console.log('--------------------------INSERT----------------------------');
    console.log('INSERT ID:', result);
    console.log('----------------------------------------------------------------');
});

connection.end();
