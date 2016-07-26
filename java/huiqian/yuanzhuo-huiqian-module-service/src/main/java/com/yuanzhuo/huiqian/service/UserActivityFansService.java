package com.yuanzhuo.huiqian.service;

import com.yuanzhuo.huiqian.model.Fans;
import com.yuanzhuo.huiqian.model.UserActivityFans;

import java.util.List;

/**
 * Created by hanfei on 16/4/19.
 */
public interface UserActivityFansService {
    int saveUserActivityFans(UserActivityFans userActivityFans);

    int deleteByActivityAndFans(int activityId, int fansId);

    void deleteByActivityId(int activityId);

    void deleteByActivityNo(String activityNo);
}
