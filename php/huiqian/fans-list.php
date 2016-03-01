<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>用户数据管理</title>

    <link
        href='http://static.zhushou001.com/??yitaoui/min/css/pagination.min.css,yitaoui/min/css/slick.min.css,yitaoui/min/css/yitao-dialog.min.css?v=105'
        rel='stylesheet' type='text/css'/>

    <!-- Bootstrap -->
    <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
    <div class="row">
        <div class="pull-left">
            <form class="form-inline" id="searchForm">
                <div class="form-group">
                    <label for="name">昵称</label>
                    <input type="text" class="form-control" id="nick" name="nick" placeholder="昵称">
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="form-group">
                    <label for="functionId">姓名</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="姓名">
                </div>
                <input type="hidden" id="userId" name="userId" value="<?php echo $_GET['userId'] ?>">
                <input type="hidden" id="activityId" name="activityId" value="<?php echo $_GET['activityId'] ?>">
                &nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-success">查询</button>
                <button type="button" class="btn btn-success" id="viewFanslist">查看活动用户</button>
                <button type="button" class="btn btn-success" id="viewBlacklist">查看黑名单</button>
            </form>
        </div>
    </div>
    <div class="row">
        <hr/>
    </div>
    <div class="row">
        <table class="table table-hover show-data-table">
            <thead>
            <tr>
                <th>用户ID</th>
                <th>用户昵称</th>
                <th>用户名</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div class="row">
        <div id="pagiation"></div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="//cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script>
<script type='text/javascript' charset='utf-8'
        src='http://static.zhushou001.com/??yitaoui/min/js/underscore.min.js,yitaoui/min/js/yitao-dialog.min.js,yitaoui/min/js/moment.min.js,yitaoui/min/js/notify.min.js,yitaoui/min/js/pagination.min.js'></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="js/jquery.cookie-1.4.1.min.js"></script>
<script src="js/fans-list.js"></script>
</body>
</html>
