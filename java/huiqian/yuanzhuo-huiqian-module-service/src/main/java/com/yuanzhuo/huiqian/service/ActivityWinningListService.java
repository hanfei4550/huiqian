package com.yuanzhuo.huiqian.service;

import com.yuanzhuo.huiqian.model.ActivityWinningList;

import java.util.List;

/**
 * Created by hanfei on 16/4/19.
 */
public interface ActivityWinningListService {

    void saveActivityWinningList(String activityWinningList);

    List<ActivityWinningList> getWinningListByActivityId(int activityId);

    void deleteByActivityId(int activityId);

}
