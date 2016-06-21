package com.yuanzhuo.huiqian.dao;

import com.yuanzhuo.huiqian.model.WhiteList;

import java.util.List;
import java.util.Map;

public interface WhiteListMapper {
    int deleteByPrimaryKey(Integer id);

    int insert(WhiteList record);

    int insertSelective(WhiteList record);

    WhiteList selectByPrimaryKey(Integer id);

    int updateByPrimaryKeySelective(WhiteList record);

    int updateByPrimaryKey(WhiteList record);

    List<WhiteList> selectByActivityId(int activityId);

    WhiteList selectByParams(Map<String, Object> params);

    int deleteByParams(Map<String, Object> params);
}