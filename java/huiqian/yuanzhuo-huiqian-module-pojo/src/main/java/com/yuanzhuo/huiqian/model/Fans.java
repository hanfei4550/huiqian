package com.yuanzhuo.huiqian.model;

import org.apache.commons.lang.StringUtils;

import java.util.Date;

public class Fans {
    private Integer id;

    private String nick;

    private String headPortraint;

    private String name;

    private Integer sex;

    private String phone;

    private String company;

    private String job;

    private String area;

    private Date createTime;

    //是否设置奖项
    private String prize = "";

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public String getNick() {
        return nick;
    }

    public void setNick(String nick) {
        this.nick = nick == null ? null : nick.trim();
    }

    public String getHeadPortraint() {
        return headPortraint;
    }

    public void setHeadPortraint(String headPortraint) {
        this.headPortraint = headPortraint == null ? null : headPortraint.trim();
    }

    public String getName() {
        return StringUtils.isBlank(name) ? "" : name;
    }

    public void setName(String name) {
        this.name = name == null ? null : name.trim();
    }

    public Integer getSex() {
        return sex;
    }

    public void setSex(Integer sex) {
        this.sex = sex;
    }

    public String getPhone() {
        return StringUtils.isBlank(phone) ? "" : phone;
    }

    public void setPhone(String phone) {
        this.phone = phone == null ? null : phone.trim();
    }

    public String getCompany() {
        return company;
    }

    public void setCompany(String company) {
        this.company = company == null ? null : company.trim();
    }

    public String getJob() {
        return job;
    }

    public void setJob(String job) {
        this.job = job == null ? null : job.trim();
    }

    public String getArea() {
        return area;
    }

    public void setArea(String area) {
        this.area = area == null ? null : area.trim();
    }

    public Date getCreateTime() {
        return createTime;
    }

    public void setCreateTime(Date createTime) {
        this.createTime = createTime;
    }

    public String getPrize() {
        return prize;
    }

    public void setPrize(String prize) {
        this.prize = prize;
    }
}