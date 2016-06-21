package com.yuanzhuo.huiqian.dao;

import com.yuanzhuo.huiqian.model.Fans;

import java.util.List;

public interface FansMapper {
    int deleteByPrimaryKey(Integer id);

    int insert(Fans record);

    int insertSelective(Fans record);

    Fans selectByPrimaryKey(Integer id);

    int updateByPrimaryKeySelective(Fans record);

    int updateByPrimaryKey(Fans record);

    List<Fans> selectFansByActivityId(int activityId);

    int deleteByActivityNo(String activityNo);
}