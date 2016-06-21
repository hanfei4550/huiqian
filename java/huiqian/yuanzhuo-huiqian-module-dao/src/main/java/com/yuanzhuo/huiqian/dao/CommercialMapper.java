package com.yuanzhuo.huiqian.dao;


import com.yuanzhuo.huiqian.model.Commercial;

public interface CommercialMapper {
    int insert(Commercial record);

    Commercial selectByRelationId(Integer userId);
}