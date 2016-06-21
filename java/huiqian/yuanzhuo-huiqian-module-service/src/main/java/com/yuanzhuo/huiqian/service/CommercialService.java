package com.yuanzhuo.huiqian.service;

import com.yuanzhuo.huiqian.core.BusinessException;
import com.yuanzhuo.huiqian.model.Commercial;

/**
 * Created by hanfei on 16/4/19.
 */
public interface CommercialService {

    /**
     * 根据用户id查询商户信息
     *
     * @param userId 用户id
     * @return 商户信息
     * @throws BusinessException 当userid为空时抛出业务异常
     */
    Commercial getCommercialByUserId(Integer userId) throws BusinessException;


    /**
     * 插入商户信息
     *
     * @param commercial 商户信息
     * @return 保存成功的数量
     * @throws BusinessException
     */
    int insert(Commercial commercial) throws BusinessException;
}
