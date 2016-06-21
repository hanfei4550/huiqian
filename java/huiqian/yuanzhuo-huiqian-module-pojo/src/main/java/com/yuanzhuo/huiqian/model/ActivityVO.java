package com.yuanzhuo.huiqian.model;

import java.io.Serializable;
import java.util.Date;

public class ActivityVO implements Serializable {
    private Integer id;

    private String name;

    private String subject;

    private String scale;

    private String beginTime;

    private String endTime;

    private String banner;

    private String industry;

    private Integer isValidateUser;

    private String functions;

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

    public String getBeginTime() {
        return beginTime;
    }

    public void setBeginTime(String beginTime) {
        this.beginTime = beginTime;
    }

    public String getEndTime() {
        return endTime;
    }

    public void setEndTime(String endTime) {
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
        return isValidateUser == null ? 0 : isValidateUser;
    }

    public void setIsValidateUser(Integer isValidateUser) {
        this.isValidateUser = isValidateUser;
    }

    public String getFunctions() {
        return functions;
    }

    public void setFunctions(String functions) {
        this.functions = functions;
    }

    @Override
    public String toString() {
        return "Activity{" +
                "id=" + id +
                ", name='" + name + '\'' +
                ", subject='" + subject + '\'' +
                ", scale='" + scale + '\'' +
                ", beginTime=" + beginTime +
                ", endTime=" + endTime +
                ", banner='" + banner + '\'' +
                ", industry='" + industry + '\'' +
                ", isValidateUser=" + isValidateUser +
                ", functions=" + functions +
                '}';
    }
}