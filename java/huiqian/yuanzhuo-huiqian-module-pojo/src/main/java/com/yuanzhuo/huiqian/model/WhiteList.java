package com.yuanzhuo.huiqian.model;

import org.apache.commons.lang.builder.ToStringBuilder;

public class WhiteList {
    private Integer id;

    private Integer fansId;

    private String fansNick;

    private Integer prizeCode;

    private Integer activityId;

    private Fans fans;

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public Integer getFansId() {
        return fansId;
    }

    public void setFansId(Integer fansId) {
        this.fansId = fansId;
    }

    public String getFansNick() {
        return fansNick;
    }

    public void setFansNick(String fansNick) {
        this.fansNick = fansNick == null ? null : fansNick.trim();
    }

    public Integer getPrizeCode() {
        return prizeCode;
    }

    public void setPrizeCode(Integer prizeCode) {
        this.prizeCode = prizeCode;
    }

    public Integer getActivityId() {
        return activityId;
    }

    public void setActivityId(Integer activityId) {
        this.activityId = activityId;
    }

    public Fans getFans() {
        return fans;
    }

    public void setFans(Fans fans) {
        this.fans = fans;
    }

    @Override
    public String toString() {
        return ToStringBuilder.reflectionToString(this);
    }
}