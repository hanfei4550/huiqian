package com.yuanzhuo.huiqian.service.impl;

import com.yuanzhuo.huiqian.core.BusinessException;
import com.yuanzhuo.huiqian.core.HuiqianErrorCode;
import com.yuanzhuo.huiqian.dao.ActivityFansMapper;
import com.yuanzhuo.huiqian.model.ActivityFans;
import com.yuanzhuo.huiqian.service.ActivityFansService;
import org.apache.commons.lang3.StringUtils;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;


/**
 * Created by hanfei on 16/4/19.
 */
@Service("activityFansService")
public class ActivityFansServiceImpl implements ActivityFansService {
    @Autowired
    private ActivityFansMapper activityFansMapper;

    @Override
    public int insert(ActivityFans activityFans) {
        int result = activityFansMapper.insert(activityFans);
        return result;
    }

    @Override
    public ActivityFans getActivityFansByUserInfo(String activityId, String name, String phone) {
        if (StringUtils.isBlank(activityId)) {
            throw new BusinessException(HuiqianErrorCode.HUIQIAN_ACTIVITYCENTER_ACTIVITY_NOT_EXISTS);
        }
        if (StringUtils.isBlank(name)) {
            throw new BusinessException(HuiqianErrorCode.HUIQIAN_USERCENTER_NAME_NULL);
        }
        if (StringUtils.isBlank(phone)) {
            throw new BusinessException(HuiqianErrorCode.HUIQIAN_USERCENTER_PHONE_NULL);
        }
        ActivityFans activityFans = new ActivityFans();
        activityFans.setActivityId(activityId);
        activityFans.setName(name);
        activityFans.setPhone(phone);
        try {
            return activityFansMapper.selectBySelective(activityFans);
        } catch (Exception ex) {
            throw new BusinessException(HuiqianErrorCode.HUIQIAN_USERCENTER_DATABASE_OPERATE_ERROR);
        }
    }

    @Override
    public void deleteByActivityId(String activityId) {
        if (StringUtils.isBlank(activityId)) {
            throw new BusinessException(HuiqianErrorCode.HUIQIAN_ACTIVITYCENTER_ACTIVITY_NOT_EXISTS);
        }
        try {
            activityFansMapper.deleteByRelationId(activityId);
        } catch (Exception ex) {
            throw new BusinessException(HuiqianErrorCode.HUIQIAN_USERCENTER_DATABASE_OPERATE_ERROR);
        }
    }
}
