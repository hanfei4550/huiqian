package com.yuanzhuo.huiqian.dao;

import com.yuanzhuo.huiqian.model.UserActivity;

public interface UserActivityMapper {
    int deleteByPrimaryKey(Integer id);

    int insert(UserActivity record);

    int insertSelective(UserActivity record);

    UserActivity selectByPrimaryKey(Integer id);

    UserActivity selectByActivityId(Integer activityId);

    int updateByPrimaryKeySelective(UserActivity record);

    int updateByPrimaryKey(UserActivity record);
}