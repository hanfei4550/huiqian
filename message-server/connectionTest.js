/**
 * Created by hanfei on 16/3/28.
 */

var mysql = require('mysql');
var connection = mysql.createConnection({
    host: '120.26.231.8',//远程MySQL数据库的ip地址
    user: 'root',
    password: 'yzqs1605',
    database: 'huiqian',
    insecureAuth: true
});

connection.connect();

connection.query('SELECT 1 + 1 AS solution', function (err, rows, fields) {
    if (err) throw err;

    console.log('The solution is: ', rows[0].solution);
});

connection.end();