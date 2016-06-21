<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>会签后台管理系统-注册</title>
    <!-- Bootstrap core CSS -->
    <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link href="<%=request.getContextPath()%>/static/css/bootstrapValidator.min.css" rel="stylesheet"/>
    <link href="<%=request.getContextPath()%>/static/css/register.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<header>
    <div class="register-header">
    </div>
</header>
<div class="container register-content">
    <div class="row">
        <div class="col-sm-3">
            <h2>欢迎加入会签</h2>
        </div>
    </div>

    <form id="registerForm" action="<%=request.getContextPath()%>/member/save.htmls" method="post"
          class="form-horizontal">
        <div class="form-group form-group-lg">
            <label for="userName" class="col-sm-2 control-label">用户名</label>

            <div class="col-sm-4">
                <input type="text" id="userName" name="userName" class="form-control" placeholder="用户名">
            </div>

            <div class="col-sm-3 col-sm-push-2">
                <span>> 已经拥有会签帐号?<a href="<%=request.getContextPath()%>/login.jsp">直接登录</a></span>
            </div>
        </div>
        <div class="form-group form-group-lg">
            <label for="password" class="col-sm-2 control-label">密码</label>

            <div class="col-sm-4">
                <input type="password" id="password" name="password" class="form-control" placeholder="密码">
            </div>
        </div>
        <div class="form-group form-group-lg">
            <label for="repassword" class="col-sm-2 control-label">确认密码</label>

            <div class="col-sm-4">
                <input type="password" id="repassword" name="repassword" class="form-control" placeholder="确认密码">
            </div>
        </div>
        <div class="form-group form-group-lg">
            <label for="company" class="col-sm-2 control-label">公司名称</label>

            <div class="col-sm-4">
                <input type="text" id="company" name="company" class="form-control" placeholder="公司名称">
            </div>
        </div>
        <div class="form-group form-group-lg">
            <label for="phone" class="col-sm-2 control-label">联系人</label>

            <div class="col-sm-4">
                <input type="text" id="phone" name="phone" class="form-control" placeholder="联系人手机号">
            </div>
        </div>
        <div class="form-group form-actions">
            <div class="col-sm-4 col-sm-push-2">
                <button type="submit" class="btn btn-primary btn-block btn-lg">注册
                </button>
            </div>
        </div>
    </form>
</div>
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<%=request.getContextPath()%>/static/js/bootstrapValidator.min.js"></script>
<script>
    $(document).ready(function () {
        $('#registerForm').bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                userName: {
                    validators: {
                        notEmpty: {
                            message: '用户名不能为空'
                        },
                        stringLength: {
                            min: 6,
                            max: 20,
                            message: '用户名必须是6到20个字符'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9_]+$/,
                            message: '用户名只能包含字母,数字和下划线'
                        }
                    }
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: '密码不能为空'
                        },
                        stringLength: {
                            min: 6,
                            max: 20,
                            message: '密码必须是6到20个字符'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9_]+$/,
                            message: '用户名只能包含字母,数字和下划线'
                        }
//                        ,
//                        identical: {
//                            field: 'repassword',
//                            message: '确认密码必须和密码相同'
//                        }
                    }
                },
                repassword: {
                    validators: {
                        notEmpty: {
                            message: '确认密码不能为空'
                        },
                        identical: {
                            field: 'password',
                            message: '确认密码必须和密码相同'
                        }
                    }
                },
                company: {
                    validators: {
                        notEmpty: {
                            message: '公司名称不能为空'
                        },
                        stringLength: {
                            max: 50,
                            message: '公司名称不能超过50个字符'
                        },
                    }
                },
                phone: {
                    validators: {
                        notEmpty: {
                            message: '联系人手机号不能为空'
                        },
                        regexp: {
                            regexp: /^(((13[0-9]{1})|(17[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/,
                            message: '联系人手机号非法'
                        },
                    }
                },
            }
        });
    });
</script>
</body>
</html>
