/**
 * Created by hanfei on 16/3/29.
 */
/**
 * Created by hanfei on 16/3/28.
 */
CHAT = {
    socket: null,
    username: null,
    headImage: null,
    openid: null,
    activityId: null,
    //提交聊天消息内容
    submit: function (obj) {
        this.socket.emit('message', obj);
        return false;
    },
    init: function (username, headImage, openid, activityId) {
        var that = this;
        this.username = username;
        this.headImage = headImage;
        this.openid = openid;
        this.activityId = activityId;

        //连接websocket后端服务器
        this.socket = io.connect('ws://www.huiqian.me:3000');

        //告诉服务器端有用户登录
        this.socket.emit('login', {
            userid: this.username,
            username: this.username,
            openid: this.openid,
            activityId: this.activityId
        });

        this.socket.emit(this.activityId);

        //监听新用户登录
        this.socket.on('login', function (o) {
            console.log("用户登录")
        });

        this.socket.on('error', function () {
            this.socket = io.connect('ws://www.huiqian.me:3000');
        });

        //监听用户退出
        this.socket.on('logout', function (o) {
            console.log("用户退出")
        });

        //监听消息发送
        this.socket.on('message', function (obj) {
            var content = '<div class="danmu-row"><span class="danmu-image"><img src="' + obj['headImage'] + '"/></span><span class="danmu-comment">' + obj['comment'] + '</span></div>';
            $("#mobileMessage").append(content);
        });

        setInterval(function () {
            that.scrollComments();
        }, 1000);

    },
    scrollComments: function () {
        var $self = $("#mobileMessage");
        var comments = $self.find("div.danmu-row");
        $.each(comments, function () {
            var commentHeight = $(this).innerHeight();
            var commentTop = $(this).offset().top;
            var nextTop = commentTop - commentHeight;
            $(this).animate({marginTop: nextTop}, 1000, 'linear', function () {
                if (nextTop < 0) {
                    $(this).remove();
                }
            });
        });

    }
};