package com.yuanzhuo.huiqian.dao;

import com.yuanzhuo.huiqian.model.FansMessage;

import java.util.Map;

public interface FansMessageMapper {
    int deleteByPrimaryKey(Long id);

    int insert(FansMessage record);

    int insertSelective(FansMessage record);

    FansMessage selectByPrimaryKey(Long id);

    int updateByPrimaryKeySelective(FansMessage record);

    int updateByPrimaryKey(FansMessage record);

    int deleteByParams(Map<String, Object> params);
}