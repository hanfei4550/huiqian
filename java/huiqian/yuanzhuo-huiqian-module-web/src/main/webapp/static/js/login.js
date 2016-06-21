/**
 * Created by hanfei on 16/5/16.
 */
$(document).ready(function () {
    $('#loginForm').bootstrapValidator({
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
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: '密码不能为空'
                    }
                }
            }
        }
    });

    var qqContent = "<p>群号为：8175132</p>";
    $("#getpasswd").popover({title: '官网产品交流群', content: qqContent, html: true, placement: 'bottom', trigger: 'hover'});
});