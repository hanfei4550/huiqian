package com.yuanzhuo.huiqian.service;

import com.yuanzhuo.huiqian.core.BusinessException;
import com.yuanzhuo.huiqian.model.Packet;
import com.yuanzhuo.huiqian.model.PacketActivityParam;

import java.util.List;

/**
 * Created by hanfei on 16/4/19.
 */
public interface PacketService {

    /**
     * 根据商户id查询红包信息
     *
     * @param commercialId 商户id
     * @return 红包信息
     * @throws BusinessException 当commercialId为空时抛出业务异常
     */
    List<Packet> getPacketsByCommercialId(Integer commercialId) throws BusinessException;


    /**
     * 插入红包信息
     *
     * @param packet 红包信息
     * @return 保存成功的数量
     * @throws BusinessException
     */
    int insert(Packet packet) throws BusinessException;


    /**
     * 根据用户id和活动id创建红包活动
     *
     * @param userId     用户id
     * @param activityId 活动id
     * @return 红包packet的列表
     * @throws BusinessException
     */
    List<Packet> createPacket(Integer userId, Integer activityId) throws BusinessException;

    /**
     * 创建红包活动
     *
     * @param token 接口token
     * @param param 红包活动参数
     * @return
     * @throws BusinessException
     */
    String createPacketActivity(String token, PacketActivityParam param) throws BusinessException;

    /**
     * 根据商户id导入红包到红包活动中
     *
     * @param token     接口token
     * @param lotteryId 红包活动id
     * @param mchId     商户号
     * @throws BusinessException
     */
    void importPacket(String token, String lotteryId, Integer mchId) throws BusinessException;
}
