package com.yuanzhuo.huiqian.model;

import org.apache.commons.lang.builder.ToStringBuilder;

import java.util.Date;

/**
 * 商户红包订单
 * Created by hanfei on 16/6/14.
 */
public class Packet {

    //授权商户号
    public static final String authmchid = "1000052601";

    //授权商户微信公众号appid
    public static final String authAppId = "wxbf42bd79c4391863";

    //订单流水Id
    private Integer id;

    //订单号
    private String billNo;

    //红包类型
    private String hbType;

    //红包金额
    private Integer totalAmount;

    //红包数量
    private Integer totalNum;

    //红包祝福语
    private String wishing;

    //活动名称
    private String actName;

    //活动备注
    private String remark;

    //风控类型
    private String riskCntl;

    //红包packet
    private String packet;

    //订单创建时间
    private Date createTime;

    //商户对象id
    private Integer commercialId;

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public String getBillNo() {
        return billNo;
    }

    public void setBillNo(String billNo) {
        this.billNo = billNo;
    }

    public String getHbType() {
        return hbType;
    }

    public void setHbType(String hbType) {
        this.hbType = hbType;
    }

    public Integer getTotalAmount() {
        return totalAmount;
    }

    public void setTotalAmount(Integer totalAmount) {
        this.totalAmount = totalAmount;
    }

    public Integer getTotalNum() {
        return totalNum;
    }

    public void setTotalNum(Integer totalNum) {
        this.totalNum = totalNum;
    }

    public String getWishing() {
        return wishing;
    }

    public void setWishing(String wishing) {
        this.wishing = wishing;
    }

    public String getActName() {
        return actName;
    }

    public void setActName(String actName) {
        this.actName = actName;
    }

    public String getRemark() {
        return remark;
    }

    public void setRemark(String remark) {
        this.remark = remark;
    }

    public String getRiskCntl() {
        return riskCntl;
    }

    public void setRiskCntl(String riskCntl) {
        this.riskCntl = riskCntl;
    }

    public String getPacket() {
        return packet;
    }

    public void setPacket(String packet) {
        this.packet = packet;
    }

    public Date getCreateTime() {
        return createTime;
    }

    public void setCreateTime(Date createTime) {
        this.createTime = createTime;
    }

    public Integer getCommercialId() {
        return commercialId;
    }

    public void setCommercialId(Integer commercialId) {
        this.commercialId = commercialId;
    }

    @Override
    public String toString() {
        return ToStringBuilder.reflectionToString(this);
    }
}
