package com.yuanzhuo.huiqian.service;

import com.yuanzhuo.huiqian.model.UserActivity;

/**
 * Created by hanfei on 16/5/12.
 */
public interface UserActivityService {
    int saveUserActivity(UserActivity userActivity);

    UserActivity getByActivityId(int activityId);
}
