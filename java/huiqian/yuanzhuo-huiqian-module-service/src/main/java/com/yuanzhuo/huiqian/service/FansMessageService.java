package com.yuanzhuo.huiqian.service;

import com.yuanzhuo.huiqian.model.Prize;
import com.yuanzhuo.huiqian.model.WhiteList;

import java.util.List;

/**
 * Created by hanfei on 16/4/19.
 */
public interface FansMessageService {

    int deleteMessageByActivityAndFans(int activityId, int fansId);

    void deleteByActivityId(int activityId);
}
