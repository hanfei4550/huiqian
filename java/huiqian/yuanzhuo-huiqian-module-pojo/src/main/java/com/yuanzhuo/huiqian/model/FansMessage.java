package com.yuanzhuo.huiqian.model;

import java.util.Date;

public class FansMessage {
    private Integer id;

    private Integer fansId;

    private String content;

    private Integer status;

    private Date createDatetime;

    private Integer userId;

    private Integer activityId;

    private Integer isDisplayInMobile;

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

    public String getContent() {
        return content;
    }

    public void setContent(String content) {
        this.content = content == null ? null : content.trim();
    }

    public Integer getStatus() {
        return status;
    }

    public void setStatus(Integer status) {
        this.status = status;
    }

    public Date getCreateDatetime() {
        return createDatetime;
    }

    public void setCreateDatetime(Date createDatetime) {
        this.createDatetime = createDatetime;
    }

    public Integer getUserId() {
        return userId;
    }

    public void setUserId(Integer userId) {
        this.userId = userId;
    }

    public Integer getActivityId() {
        return activityId;
    }

    public void setActivityId(Integer activityId) {
        this.activityId = activityId;
    }

    public Integer getIsDisplayInMobile() {
        return isDisplayInMobile;
    }

    public void setIsDisplayInMobile(Integer isDisplayInMobile) {
        this.isDisplayInMobile = isDisplayInMobile;
    }
}