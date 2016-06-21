package com.yuanzhuo.huiqian.dao;

import com.yuanzhuo.huiqian.model.UserActivityFans;

import java.util.Map;

public interface UserActivityFansMapper {
    int deleteByPrimaryKey(Integer id);

    int insert(UserActivityFans record);

    int insertSelective(UserActivityFans record);

    UserActivityFans selectByPrimaryKey(Integer id);

    int updateByPrimaryKeySelective(UserActivityFans record);

    int updateByPrimaryKey(UserActivityFans record);

    int deleteByActivityNo(String activityNo);

    int deleteByParams(Map<String, Object> params);
}