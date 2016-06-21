package com.yuanzhuo.huiqian.model;

import org.apache.commons.lang.builder.ToStringBuilder;

import java.util.Date;

/**
 * 红包活动参数
 * Created by hanfei on 16/6/14.
 */
public class PacketActivityParam {
    //商户号
    private Integer mchId;
    //红包图片url
    private String logoUrl;
    //红包标题
    private String title;
    //红包描述
    private String desc;
    //红包活动开关
    private Integer onoff;
    //红包活动开始时间
    private Date startTime;
    //红包活动结束时间
    private Date endTime;
    //红包提供商户appid
    private String sponsorAppid;
    //红包总数量
    private Integer total;
    //跳转的url
    private String jumpUrl;
    //自定义key
    private String key;

    public Integer getMchId() {
        return mchId;
    }

    public void setMchId(Integer mchId) {
        this.mchId = mchId;
    }

    public String getLogoUrl() {
        return logoUrl;
    }

    public void setLogoUrl(String logoUrl) {
        this.logoUrl = logoUrl;
    }

    public String getTitle() {
        return title;
    }

    public void setTitle(String title) {
        this.title = title;
    }

    public String getDesc() {
        return desc;
    }

    public void setDesc(String desc) {
        this.desc = desc;
    }

    public Integer getOnoff() {
        return onoff;
    }

    public void setOnoff(Integer onoff) {
        this.onoff = onoff;
    }

    public Date getStartTime() {
        return startTime;
    }

    public void setStartTime(Date startTime) {
        this.startTime = startTime;
    }

    public Date getEndTime() {
        return endTime;
    }

    public void setEndTime(Date endTime) {
        this.endTime = endTime;
    }

    public String getSponsorAppid() {
        return sponsorAppid;
    }

    public void setSponsorAppid(String sponsorAppid) {
        this.sponsorAppid = sponsorAppid;
    }

    public Integer getTotal() {
        return total;
    }

    public void setTotal(Integer total) {
        this.total = total;
    }

    public String getJumpUrl() {
        return jumpUrl;
    }

    public void setJumpUrl(String jumpUrl) {
        this.jumpUrl = jumpUrl;
    }

    public String getKey() {
        return key;
    }

    public void setKey(String key) {
        this.key = key;
    }

    @Override
    public String toString() {
        return ToStringBuilder.reflectionToString(this);
    }
}
