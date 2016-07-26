package com.yuanzhuo.huiqian.service.impl;

import com.yuanzhuo.huiqian.dao.UserActivityFansMapper;
import com.yuanzhuo.huiqian.model.UserActivityFans;
import com.yuanzhuo.huiqian.service.UserActivityFansService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.HashMap;
import java.util.Map;

/**
 * Created by hanfei on 16/5/28.
 */
@Service("userActivityFansService")
public class UserActivityFansServiceImpl implements UserActivityFansService {

    @Autowired
    private UserActivityFansMapper userActivityFansMapper;

    @Override
    public int saveUserActivityFans(UserActivityFans userActivityFans) {
        return userActivityFansMapper.insertSelective(userActivityFans);
    }

    @Override
    public int deleteByActivityAndFans(int activityId, int fansId) {
        Map<String, Object> params = new HashMap<String, Object>();
        params.put("activityId", activityId);
        params.put("fansId", fansId);
        return userActivityFansMapper.deleteByParams(params);
    }

    @Override
    public void deleteByActivityId(int activityId) {
        Map<String, Object> params = new HashMap<String, Object>();
        params.put("activityId", activityId);
        userActivityFansMapper.deleteByParams(params);
    }

    @Override
    public void deleteByActivityNo(String activityNo) {
        userActivityFansMapper.deleteByActivityNo(activityNo);
    }
}
