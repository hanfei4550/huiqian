package com.yuanzhuo.huiqian.dao;

import com.yuanzhuo.huiqian.model.Activity;

import java.util.List;

public interface ActivityMapper {
    int deleteByPrimaryKey(Integer id);

    int insert(Activity record);

    int insertSelective(Activity record);

    Activity selectByPrimaryKey(Integer id);

    Activity selectByActivityNo(String activityNo);

    int updateByPrimaryKeySelective(Activity record);

    int updateByPrimaryKey(Activity record);

    List<Activity> selectAllActivity();

    List<Activity> selectActivityByUserId(int memberId);
}