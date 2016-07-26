package com.yuanzhuo.huiqian.dao;

import com.yuanzhuo.huiqian.model.ActivityWinningList;

import java.util.List;

public interface ActivityWinningListMapper {
    int deleteByPrimaryKey(Integer id);

    int insert(ActivityWinningList record);

    int insertSelective(ActivityWinningList record);

    ActivityWinningList selectByPrimaryKey(Integer id);

    int updateByPrimaryKeySelective(ActivityWinningList record);

    int updateByPrimaryKey(ActivityWinningList record);

    List<ActivityWinningList> selectByActivityId(int activityId);

    void deleteByRelationId(int activityId);
}