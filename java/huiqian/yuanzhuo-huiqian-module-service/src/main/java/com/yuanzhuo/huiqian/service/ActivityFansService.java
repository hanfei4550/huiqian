package com.yuanzhuo.huiqian.service;

import com.yuanzhuo.huiqian.model.ActivityFans;

/**
 * Created by hanfei on 16/4/19.
 */
public interface ActivityFansService {

    int insert(ActivityFans activityFans);

    ActivityFans getActivityFansByUserInfo(String activityId, String name, String phone);

    void deleteByActivityId(String activityId);
}
