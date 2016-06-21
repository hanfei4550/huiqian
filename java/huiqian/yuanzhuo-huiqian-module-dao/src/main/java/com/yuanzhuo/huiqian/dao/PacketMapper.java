package com.yuanzhuo.huiqian.dao;


import com.yuanzhuo.huiqian.model.Packet;

import java.util.List;

public interface PacketMapper {
    int insert(Packet record);

    List<Packet> selectByRelationId(Integer commercialId);
}