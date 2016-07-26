package com.yuanzhuo.huiqian.service;

import com.yuanzhuo.huiqian.model.Activity;
import com.yuanzhuo.huiqian.model.ActivityVO;
import com.yuanzhuo.huiqian.model.User;

import java.util.List;

/**
 * Created by hanfei on 16/4/19.
 */
public interface ActivityService {
    List<Activity> getAllActivity(int pageIndex, int pageSize) throws Exception;

    int getTotal() throws Exception;

    Activity getActivityById(int id);

    List<Activity> getActivityByMemberId(int memberId, int pageIndex, int pageSize) throws Exception;

    int getTotalByMemberId(int memberId) throws Exception;

    int saveActivity(ActivityVO activityVO);

    Activity getActivityByActivityNo(String activityNo);

    void deleteActivityDataByActivityNo(String activityNo);

    void deleteActivityById(int activityId);

    void recoverActivityDataByActivityNoAndFile(int userId, int activityId, String filePath);
}
