package com.yuanzhuo.huiqian.core;

/**
 * 会签业务异常设计
 * Created by hanfei on 16/5/10.
 */
public enum HuiqianErrorCode {
    HUIQIAN_USERCENTER_DATABASE_OPERATE_ERROR("500", "数据库操作异常!"),
    HUIQIAN_USERCENTER_USERNAME_NULL("1O000", "用户名为空"),
    HUIQIAN_USERCENTER_PASSWORD_NULL("10001", "密码为空"),
    HUIQIAN_USERCENTER_MEMBER_NULL("10002", "会员为空"),
    HUIQIAN_USERCENTER_USERID_NULL("10003", "用户ID为空"),
    HUIQIAN_USERCENTER_COMMERCIALID_NULL("10004", "商户ID为空"),
    HUIQIAN_USERCENTER_NAME_NULL("1O005", "姓名为空"),
    HUIQIAN_USERCENTER_PHONE_NULL("10006", "手机号为空"),
    HUIQIAN_ACTIVITYCENTER_ACTIVITYNO_NULL("20000", "活动标识生成失败."),
    HUIQIAN_ACTIVITYCENTER_QRCODE_ERROR("20001", "活动二维码生成失败."),
    HUIQIAN_ACTIVITYCENTER_ACTIVITY_NOT_EXISTS("20002", "活动不存在.");


    private String value;
    private String desc;

    private HuiqianErrorCode(String value, String desc) {
        this.setValue(value);
        this.setDesc(desc);
    }

    public String getValue() {
        return value;
    }

    public void setValue(String value) {
        this.value = value;
    }

    public String getDesc() {
        return desc;
    }

    public void setDesc(String desc) {
        this.desc = desc;
    }

    @Override
    public String toString() {
        return "[" + this.value + "]" + this.desc;
    }
}
