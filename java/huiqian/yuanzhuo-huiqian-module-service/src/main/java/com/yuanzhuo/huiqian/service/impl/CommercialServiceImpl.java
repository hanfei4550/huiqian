package com.yuanzhuo.huiqian.service.impl;

import com.yuanzhuo.huiqian.core.BusinessException;
import com.yuanzhuo.huiqian.core.HuiqianErrorCode;
import com.yuanzhuo.huiqian.dao.CommercialMapper;
import com.yuanzhuo.huiqian.model.Commercial;
import com.yuanzhuo.huiqian.service.CommercialService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

/**
 * 商户服务实现
 * Created by hanfei on 16/6/14.
 */
@Service("commercialService")
public class CommercialServiceImpl implements CommercialService {
    @Autowired
    private CommercialMapper commercialMapper;

    @Override
    public Commercial getCommercialByUserId(Integer userId) throws BusinessException {
        if (null == userId) {
            throw new BusinessException(HuiqianErrorCode.HUIQIAN_USERCENTER_USERID_NULL);
        }
        return commercialMapper.selectByRelationId(userId);
    }

    @Override
    public int insert(Commercial commercial) throws BusinessException {
        return commercialMapper.insert(commercial);
    }
}
