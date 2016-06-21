package com.yuanzhuo.huiqian.model;

import org.apache.commons.lang.StringUtils;
import org.apache.commons.lang.builder.ToStringBuilder;

import java.io.Serializable;
import java.util.Date;

public class Activity implements Serializable {
    private Integer id;

    private String name;

    private String subject;

    private String scale;

    private Date beginTime;

    private Date endTime;

    private String banner;

    private String industry;

    private Integer isValidateUser;

    private String functions;

    private String activityNo;

    //红包配置
    private String packetConfig;
    //是否是弹幕活动
    private Integer isDanmu;

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name == null ? null : name.trim();
    }

    public String getSubject() {
        return subject;
    }

    public void setSubject(String subject) {
        this.subject = subject == null ? null : subject.trim();
    }

    public String getScale() {
        return scale;
    }

    public void setScale(String scale) {
        this.scale = scale == null ? null : scale.trim();
    }

    public Date getBeginTime() {
        return beginTime;
    }

    public void setBeginTime(Date beginTime) {
        this.beginTime = beginTime;
    }

    public Date getEndTime() {
        return endTime;
    }

    public void setEndTime(Date endTime) {
        this.endTime = endTime;
    }

    public String getBanner() {
        return banner;
    }

    public void setBanner(String banner) {
        this.banner = banner == null ? null : banner.trim();
    }

    public String getIndustry() {
        return industry;
    }

    public void setIndustry(String industry) {
        this.industry = industry == null ? null : industry.trim();
    }

    public Integer getIsValidateUser() {
        return isValidateUser;
    }

    public void setIsValidateUser(Integer isValidateUser) {
        this.isValidateUser = isValidateUser;
    }

    public String getFunctions() {
        return StringUtils.isBlank(functions) ? "" : functions;
    }

    public void setFunctions(String functions) {
        this.functions = functions;
    }

    public String getActivityNo() {
        return activityNo;
    }

    public void setActivityNo(String activityNo) {
        this.activityNo = activityNo;
    }

    public String getPacketConfig() {
        return packetConfig;
    }

    public void setPacketConfig(String packetConfig) {
        this.packetConfig = packetConfig;
    }

    public Integer getIsDanmu() {
        return isDanmu;
    }

    public void setIsDanmu(Integer isDanmu) {
        this.isDanmu = isDanmu;
    }

    @Override
    public String toString() {
        return ToStringBuilder.reflectionToString(this);
    }
}