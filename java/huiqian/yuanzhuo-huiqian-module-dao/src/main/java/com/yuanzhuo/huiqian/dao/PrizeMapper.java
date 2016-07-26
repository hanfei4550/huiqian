package com.yuanzhuo.huiqian.dao;

import com.yuanzhuo.huiqian.model.Prize;

import java.util.List;

public interface PrizeMapper {
    int deleteByPrimaryKey(Integer id);

    int insert(Prize record);

    int insertSelective(Prize record);

    List<Prize> selectByActivityId(int activityId);

    Prize selectByPrimaryKey(Integer id);

    int updateByPrimaryKeySelective(Prize record);

    int updateByPrimaryKey(Prize record);

    void deleteByRelationId(int activityId);
}