package com.yuanzhuo.huiqian.model;

import org.apache.commons.lang.builder.ToStringBuilder;

/**
 * 商户对象
 * Created by hanfei on 16/6/14.
 */
public class Commercial {
    //商户流水id
    private Integer id;

    //商户号
    private Integer mchId;

    //商户的微信公众号appid
    private String wxAppId;

    //商户密钥
    private String secret;

    //商户名称
    private String mchName;

    //商户的随机字符串
    private String nonceStr;

    //会员对象
    private Integer userId;

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public Integer getMchId() {
        return mchId;
    }

    public void setMchId(Integer mchId) {
        this.mchId = mchId;
    }

    public String getWxAppId() {
        return wxAppId;
    }

    public void setWxAppId(String wxAppId) {
        this.wxAppId = wxAppId;
    }

    public String getMchName() {
        return mchName;
    }

    public void setMchName(String mchName) {
        this.mchName = mchName;
    }

    public String getNonceStr() {
        return nonceStr;
    }

    public void setNonceStr(String nonceStr) {
        this.nonceStr = nonceStr;
    }

    public Integer getUserId() {
        return userId;
    }

    public void setUserId(Integer userId) {
        this.userId = userId;
    }

    public String getSecret() {
        return secret;
    }

    public void setSecret(String secret) {
        this.secret = secret;
    }

    @Override
    public String toString() {
        return ToStringBuilder.reflectionToString(this);
    }
}
