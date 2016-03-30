/**
 * Created by hanfei on 16/3/28.
 */
var express = require('express');
var messageDao = require('../dao/messageDao');
var router = express.Router();

/* GET users listing. */
router.get('/', function (req, res, next) {
    res.send('respond with a resource');
});

router.get('/queryAllMessage', function (req, res, next) {
    messageDao.queryAllMessage(req, res, next);
});

module.exports = router;