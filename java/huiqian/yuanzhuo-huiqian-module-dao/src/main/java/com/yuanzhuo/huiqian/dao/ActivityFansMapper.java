package com.yuanzhuo.huiqian.dao;

import com.yuanzhuo.huiqian.model.ActivityFans;

public interface ActivityFansMapper {
    int deleteByPrimaryKey(Integer id);

    int insert(ActivityFans record);

    int insertSelective(ActivityFans record);

    ActivityFans selectByPrimaryKey(Integer id);

    int updateByPrimaryKeySelective(ActivityFans record);

    int updateByPrimaryKey(ActivityFans record);
}