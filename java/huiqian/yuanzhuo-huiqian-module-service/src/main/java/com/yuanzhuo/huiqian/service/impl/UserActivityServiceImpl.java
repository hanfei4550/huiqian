package com.yuanzhuo.huiqian.service.impl;

import com.yuanzhuo.huiqian.dao.UserActivityMapper;
import com.yuanzhuo.huiqian.model.UserActivity;
import com.yuanzhuo.huiqian.service.UserActivityService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

/**
 * Created by hanfei on 16/5/12.
 */
@Service("userActivityService")
public class UserActivityServiceImpl implements UserActivityService {
    @Autowired
    private UserActivityMapper userActivityMapper;

    @Override
    public int saveUserActivity(UserActivity userActivity) {
        return userActivityMapper.insert(userActivity);
    }

    @Override
    public UserActivity getByActivityId(int activityId) {
        return userActivityMapper.selectByActivityId(activityId);
    }
}
